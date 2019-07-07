
import javax.swing.*;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author huynh
 */
public class MainClass {

    public static void main(String[] args) {

        Object[] selectioValues = {"Server", "Client"};
        String initialSection = "Server";

        Object selection = JOptionPane.showInputDialog(null, "Login as : ", "CommunicateClientServer", JOptionPane.QUESTION_MESSAGE, null, selectioValues, initialSection);
        if (selection.equals("Server")) {
            String[] arguments = new String[]{};
            new Server().main(arguments);
        } else if (selection.equals("Client")) {
            String IPServer = JOptionPane.showInputDialog("Enter the Server ip adress");
            String[] arguments = new String[]{IPServer};
            new Client().main(arguments);
        }

    }
}
