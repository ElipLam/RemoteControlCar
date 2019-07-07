
import java.awt.BorderLayout;
import java.io.DataInputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.Box;
import javax.swing.JFrame;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.SwingUtilities;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author huynh
 */
public class Server {

    // The server socket.
    private static ServerSocket serverSocket = null;
    // The client socket.
    private static Socket clientSocket = null;
    private static DataInputStream is = null;
    private static PrintStream os = null;
    private static String clientName = null;
    // The user thread
    private static final int maxUsersCount = 10;
    private static final UserThread[] userThreads = new UserThread[maxUsersCount];
    // The car thread
    private static final int maxCarsCount = 3;
    private static final CarThread[] carThreads = new CarThread[maxCarsCount];

    public static JTextArea textArea;

    /* ******************************************************** */

    /*Server Frame*/
    public static class ServerBoard extends JFrame {

        public ServerBoard() {
            textArea = new JTextArea(20, 50);
            textArea.setEditable(false);
            textArea.setLineWrap(true);
            add(new JScrollPane(textArea), BorderLayout.CENTER);

            Box box = Box.createHorizontalBox();
            add(box, BorderLayout.SOUTH);
        }

    }

    /**
     * Updates the UI
     */
    public static void updateTextArea(String message) {
        SwingUtilities.invokeLater(new Runnable() {
            public void run() {
                textArea.append(message);
                textArea.append("\n");
            }
        });
    }

    /* ******************************************************** */
    /* Main */
    public static void main(String args[]) {
        //Create Frame
        JFrame frame = new ServerBoard();
        frame.setTitle("Server is Running");
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setResizable(false);
        frame.setVisible(true);

        // The default port number.
        int portNumber = 2345;
        if (args.length < 1) {
            System.out.println("Usage: java MultiThreadServerSync <portNumber>\n"
                    + "Now using port " + portNumber);
        } else {
            portNumber = Integer.valueOf(args[0]).intValue();
        }

        /*
         * Open a server socket on the portNumber (default 2222). Note that we can
         * not choose a port less than 1023 if we are not privileged users (root).
         */
        try {
            serverSocket = new ServerSocket(portNumber);
            updateTextArea("*** Server is running on port: " + portNumber);
        } catch (IOException e) {
            System.out.println(e);
            updateTextArea(e.toString());
        }

        /*
         * Create a client socket for each connection and pass it to a new client
         * thread.
         */
        while (true) {
            try {
                clientSocket = serverSocket.accept();
                is = new DataInputStream(clientSocket.getInputStream());
                os = new PrintStream(clientSocket.getOutputStream());
                clientName = GetClientName();

                // Create Car Thread
                if (clientName.equals("ESP8266")) {
                    int i = 0;
                    for (i = 0; i < maxCarsCount; i++) {
                        if (carThreads[i] == null) {
                            (carThreads[i] = new CarThread(clientSocket, userThreads, carThreads, new CarThread.OnMessageReceived() {
                                @Override
                                public void messageReceived(String message) {
                                    updateTextArea(message);
                                }
                            }, clientName)).start();
                            break;
                        }
                    }
                    if (i == maxCarsCount) {
                        os.println("SERVER TOO BUSY. TRY AGAIN.");
                        os.close();
                        clientSocket.close();
                        //Clean up all Car Thread
                        for (i = 0; i < maxCarsCount; i++) {
                            carThreads[i].stop();
                            carThreads[i] = null;
                        }
                        i = 0;
                    }
                } // Create User Thread
                else {
                    int j = 0;
                    for (j = 0; j < maxUsersCount; j++) {
                        if (userThreads[j] == null) {
                            (userThreads[j] = new UserThread(clientSocket, userThreads, carThreads, new UserThread.OnMessageReceived() {
                                @Override
                                public void messageReceived(String message) {
                                    updateTextArea(message);
                                }
                            }, clientName)).start();
                            break;
                        }
                    }
                    if (j == maxUsersCount) {
                        os.println("SERVER TOO BUSY. TRY AGAIN.");
                        os.close();
                        clientSocket.close();
                        for (j = 0; j < maxCarsCount; j++) {
                            userThreads[j].stop();
                            userThreads[j] = null;
                        }
                        j = 0;
                    }
                }

            } catch (IOException e) {
                System.out.println(e);
                updateTextArea(e.toString());
            }
        }
    }

    private static String GetClientName() {
        try {
            /* Welcome the new the client. */
            os.println("WELCOME-YOU'RE CONNECTED");
            String name;
            while (true) {
                name = is.readLine().trim();
                if (!name.equals("")) {
                    break;
                }
            }
            return name;
        } catch (IOException ex) {
            System.out.println(ex);
        }
        return null;
    }
}
