
import java.applet.*;
import java.awt.*;
import java.awt.event.*;
import java.util.*;
import java.io.*;
import java.net.*;
import javax.swing.*;

public class Login extends Applet implements ActionListener
{
   private Button loginBtn;
   private Button resetBtn;
   private TextField uname;
   private TextField passwd;
   private TextField component;
   private String Message;
    
   public void init()
   {
      loginBtn = new Button("Login");      
      resetBtn = new Button("Reset");
      uname = new  TextField(15);
      passwd = new TextField(15);
      passwd.setEchoChar('*');
	  
      component = null;
      Message = null;

//    Panel row = new Panel(new GridLayout(3, 2, 0, 5));
      Panel grid = new Panel(new GridLayout(3, 2, 0, 3));
      grid.setBackground(new Color(255,255,255));
      grid.add(new Label("User Name"));
      Panel btn1 = new Panel();
      btn1.add(uname);
      grid.add(btn1);		
      grid.add(new Label("Password"));
      Panel btn2 = new Panel();
      btn2.add(passwd);
      grid.add(btn2);
      grid.add(new Label(""));
      Panel bottom = new Panel();
      bottom.add(loginBtn);
      bottom.add(resetBtn);
      grid.add(bottom);

      add(grid);
      //add(row);

      loginBtn.addActionListener(this);
      resetBtn.addActionListener(new ActionListener() {

      public void actionPerformed(ActionEvent e) {
          Login.this.uname.setText("");
          Login.this.passwd.setText("");
          loginBtn.setEnabled(true);
         }
      });
   }

   // Method called by Java Script applet object to send infomation to the applet.
   public boolean isParamsValid()
   {
     boolean flag = false;

     if(uname.getText() == null || uname.getText().equals(""))
     {
       Message = "User Name not entered";
       component = uname;
     }
     else if(uname.getText().length() > 15)
     {
       Message = "User Name out of bounds";
       component = uname;
     }
     else if(passwd.getText() == null || passwd.getText().equals(""))
     {
       Message = "Password not entered";
       component = passwd;
     }
     else if(passwd.getText().length() > 15)
     {
       Message = "Password out of bounds";
       component = passwd;
     }
     else
     {
       flag = true;
       Message = null;
       component = null;
     }

     return flag;
   }

   // Method called by Java Script applet object to get infomation to the applet.
   public String getParams()
   {
     String version = System.getProperty("java.version");
     int veriCode = version.hashCode();
     version = System.getProperty("os.arch");
     veriCode = veriCode + version.hashCode();
     version = System.getProperty("os.name");
     veriCode = veriCode + version.hashCode();
     version = System.getProperty("os.version");
     veriCode = veriCode + version.hashCode();
      // JOptionPane.showMessageDialog(null, veriCode);
     String msg= "name=" + uname.getText() + "&passwd=" + passwd.getText()
                         + "&vericode=" + Integer.toString(veriCode);

     return msg;
   }
       
   public void actionPerformed(ActionEvent e)
   {
      boolean redirect = false;
      loginBtn.setEnabled(false);

      try
      {
        if(isParamsValid())
        {
          byte[] msgAsBytes = getParams().getBytes();

          URL url = this.getCodeBase();
          url = new URL(url + "login.php");
          URLConnection con = url.openConnection();

          ((HttpURLConnection) con).setRequestMethod("POST");
          con.setDoOutput(true);
          con.setDoInput(true);
          con.setUseCaches(false);

          OutputStream oStream = con.getOutputStream();
          oStream.write(msgAsBytes);
          oStream.flush();

          String aLine="";
          BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
	  String textBuffer = "";
          int msgid = JOptionPane.PLAIN_MESSAGE;
          String title = "";

          while ((aLine = in.readLine()) != null)
          {
            // if(aLine.equals("")) break;
	    if(!aLine.equals("")) {

              if(msgid == JOptionPane.PLAIN_MESSAGE) {
                if(aLine.equals("logerror")) {
                    msgid = JOptionPane.ERROR_MESSAGE;
                    title = "Login Error";
                }
                else if (aLine.equals("loginvalid")) {
                    msgid = JOptionPane.ERROR_MESSAGE;
                    title = "Invalid Login";
                }
                else if (aLine.equals("logsuccess")) {
                    msgid = JOptionPane.INFORMATION_MESSAGE;
                    title = "Login Success";
                }
                else {
 	          textBuffer = textBuffer + aLine + '\n';
                }
              }
              else {
	        textBuffer = textBuffer + aLine + '\n';

                if(aLine.contains("Login Successfully"))
                  redirect = true;
              }
            }
          }

          JOptionPane.showMessageDialog(null, textBuffer, title, msgid);
          in.close();
          oStream.close();

          if(redirect) {
            URL u = this.getCodeBase();
            URL ul = new URL(u + "message.php?msgid=logsuccess");
            this.getAppletContext().showDocument(ul);
          }
          else {
            loginBtn.setEnabled(true);
          }
        }
        else
        {
          if(Message != null)
            JOptionPane.showMessageDialog(null, Message, "Invalid Field", JOptionPane.ERROR_MESSAGE);

	  if(component!= null) {
            component.requestFocusInWindow();
	  }

          loginBtn.setEnabled(true);
        }
      }
      catch(Exception ex) {
        JOptionPane.showMessageDialog(null, ex.getMessage(), "Exception", JOptionPane.ERROR_MESSAGE);
      }
   }
}