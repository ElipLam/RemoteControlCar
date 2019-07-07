
import java.io.DataInputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.net.Socket;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author huynh
 */
public class CarThread extends Thread {

    /*Declare Variable*/
    private int status;
    private String clientName = null;
    private DataInputStream is = null;
    public PrintStream os = null;
    private Socket clientSocket = null;
	private final UserThread[] userThreads;
    private final CarThread[] carThreads;
    private int maxClientsCount;
	private int maxUsersCount;
    private OnMessageReceived messageListener;

    public CarThread(Socket clientSocket, UserThread[] userThreads, CarThread[] carthreads, OnMessageReceived messageListener, String clientName) {
        this.clientSocket = clientSocket;
		this.userThreads = userThreads;
        this.carThreads = carthreads;
        maxClientsCount = carthreads.length;
        this.messageListener = messageListener;
		this.maxUsersCount = userThreads.length;
        this.clientName = clientName;
        setStatus(1);
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
        UpdateCarStatus(status);
    }

    public String getClientName() {
        return clientName;
    }

    private void UpdateCarStatus(int status) {
        try {
            Connection connection = MySQLConnUtils.getMySQLConnection();
            String sql = "Update cars set state = ? where id = 1";
            PreparedStatement pstm = connection.prepareStatement(sql);
            pstm.setInt(1, status);
            int rc = pstm.executeUpdate();
            System.out.println("Row count affected " + rc);
        } catch (SQLException | ClassNotFoundException e) {
            System.out.println(e);
        }
    }

    public void run() {

        int maxClientsCount = this.maxClientsCount;
		UserThread[] userThreads = this.userThreads;
        CarThread[] carthreads = this.carThreads;

        try {
            /*
             * Create input and output streams for this client.
             */
            is = new DataInputStream(clientSocket.getInputStream());
            os = new PrintStream(clientSocket.getOutputStream());

            messageListener.messageReceived("*** " + clientName + " joined");
            
            /* Update status */
            setStatus(1);

            /* Start the conversation. */
            while (true) {
                String line = is.readLine();
                if (line.startsWith("/quit")) {
                    break;
                }
				
				if (line.equals("e"))
				{
					for (int i = 0; i < maxUsersCount; i++)
					{
						if (userThreads[i] != null && userThreads[i].getControllingCar() != null && userThreads[i].getControllingCar() == this )
						{
							userThreads[i].os.println("e");
						}
					}
				}

                messageListener.messageReceived("<" + clientName + ">" + line);
            }

            messageListener.messageReceived("*** " + clientName + " disconnected");

            /*
             * Clean up. Set the current thread variable to null so that a new client
             * could be accepted by the server.
             */
            synchronized (this) {
                for (int i = 0; i < maxClientsCount; i++) {
                    if (carthreads[i] == this) {
                        carthreads[i].setStatus(0);
                        carthreads[i] = null;
                    }
                }
            }
            /*
             * Close the output stream, close the input stream, close the socket.
             */
            is.close();
            os.close();
            clientSocket.close();
        } catch (IOException e) {
            System.out.println(e);
        }
    }

    //must be implemented in Server 
    public interface OnMessageReceived {

        public void messageReceived(String message);
    }
}
