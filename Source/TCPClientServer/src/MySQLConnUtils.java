/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author huynh
 */
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
 
public class MySQLConnUtils 
{
    public static Connection getMySQLConnection() throws SQLException, ClassNotFoundException 
    {
        String hostName = "localhost";
        String dbName = "mydatabase";
        String userName = "root";
        String password = "password";
 
        return getMySQLConnection(hostName, dbName, userName, password);
    }
 
    public static Connection getMySQLConnection(String hostName, String dbName, String userName, String password) throws SQLException, ClassNotFoundException 
    {
 
        String connectionURL = "jdbc:mysql://" + hostName + ":3306/" + dbName;
 
        Connection conn = DriverManager.getConnection(connectionURL, userName, password);
        return conn;
    }
}