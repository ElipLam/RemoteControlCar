
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
public class ClientThread extends Thread {

    private String clientName = null;
    private DataInputStream is = null;
    private PrintStream os = null;
    private Socket clientSocket = null;
    private final ClientThread[] threads;
    private int maxClientsCount;
    private OnMessageReceived messageListener;

    public ClientThread(Socket clientSocket, ClientThread[] threads, OnMessageReceived messageListener) {
        this.clientSocket = clientSocket;
        this.threads = threads;
        maxClientsCount = threads.length;
        this.messageListener = messageListener;
    }

    public void run() {
        int maxClientsCount = this.maxClientsCount;
        ClientThread[] threads = this.threads;

        try {
            /*
       * Create input and output streams for this client.
             */
            is = new DataInputStream(clientSocket.getInputStream());
            os = new PrintStream(clientSocket.getOutputStream());

            /* Welcome the new the client. */
            String name;
            while (true) {
                os.println("Welcome-You are connected");
                name = is.readLine().trim();
                if (!name.equals("")) {
                    if (name.equals("ESP8266")) {
                        CleanUpESPThreads();
                    }
                    break;
                }
            }

            synchronized (this) {
                for (int i = 0; i < maxClientsCount; i++) {
                    if (threads[i] != null && threads[i] == this) {
                        clientName = name;
                        break;
                    }
                }
                messageListener.messageReceived("*** " + clientName + " joined");
            }
            /* Start the conversation. */
            while (true) {
                String line = is.readLine();
                if (line.startsWith("/quit")) {
                    break;
                }
                /* The message is public, broadcast it to all other clients. */
                synchronized (this) {
                    for (int i = 0; i < maxClientsCount; i++) {
                        if (threads[i] != null && threads[i].clientName != null) {
                            threads[i].os.println(line);
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
                    if (threads[i] == this) {
                        threads[i] = null;
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

    public void CleanUpESPThreads() {
        synchronized (this) {
            for (int i = 0; i < maxClientsCount; i++) {
                if (threads[i] != null && threads[i] != this && threads[i].clientName == "ESP8266") {
                    threads[i] = null;
                }
            }
        }
    }

    //must be implemented in Server 
    public interface OnMessageReceived {

        public void messageReceived(String message);
    }

}
