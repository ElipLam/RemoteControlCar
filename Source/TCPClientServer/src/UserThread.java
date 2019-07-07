
import java.io.DataInputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.net.Socket;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author huynh
 */
public class UserThread extends Thread {

    private String clientName = null;
    private DataInputStream is = null;
    public PrintStream os = null;
    private Socket clientSocket = null;
    
    private int maxClientsCount;
    private final UserThread[] userThreads;
    
    private int maxCarsCount;
    private final CarThread[] carThreads;
    private CarThread carControlling = null;
    
    private OnMessageReceived messageListener;

    public UserThread(Socket clientSocket, UserThread[] userThreads, CarThread[] carThreads, OnMessageReceived messageListener, String clientName) {      
        this.clientName = clientName;
        this.clientSocket = clientSocket;
        
        this.userThreads = userThreads;
        this.maxClientsCount = userThreads.length;
        
        this.carThreads = carThreads;
        this.maxCarsCount = carThreads.length;
        
        this.messageListener = messageListener;
    }

    public void run() {
        
        int maxClientsCount = this.maxClientsCount;
        UserThread[] userThreads = this.userThreads;
        
        int maxCarsCount = this.maxCarsCount;
        CarThread[] carThreads = this.carThreads;

        try {
            /*
             * Create input and output streams for this client.
             */
            is = new DataInputStream(clientSocket.getInputStream());
            os = new PrintStream(clientSocket.getOutputStream());

            messageListener.messageReceived("*** " + clientName + " joined");
            
            /* Start the conversation. */
            while (true) {
                String line = is.readLine();
                if (line.startsWith("/quit")) {
                    break;
                }
                
                if (line.equals("Choose car 1")) {
                     
                         for (int i = 0; i < maxCarsCount; i++)
                         {
                             if (carThreads[i] != null && carThreads[i].getClientName().equals("ESP8266")) {
                                 if (carThreads[i].getStatus() == 1) {
                                    carControlling = carThreads[i];
                                    carThreads[i].setStatus(3);
                                    this.os.println("Choose car success");
                                 }
                                 else {
                                     this.os.println("The car you chose is offline or busy");
                                 }
                             }
                         }
                     
                }
                else {
                    if (carControlling != null) {
                        carControlling.os.println(line);
                    }
                } 
                
                this.os.println(line);
                messageListener.messageReceived("<" + clientName + ">" + line);
            }

            messageListener.messageReceived("*** " + clientName + " disconnected");

            /*
             * Clean up. Set the current thread variable to null so that a new client
             * could be accepted by the server.
             */
            synchronized (this) {
                for (int i = 0; i < maxClientsCount; i++) {
                    if (userThreads[i] == this) {
                        userThreads[i] = null;
                        userThreads[i].stop();
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
	
	public CarThread getControllingCar()
	{
		return this.carControlling;
	}

    //must be implemented in Server 
    public interface OnMessageReceived {

        public void messageReceived(String message);
    }

}
