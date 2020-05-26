
import java.applet.*;
import java.awt.*;
import java.awt.event.*;
import java.util.*;
import java.io.*;
import java.net.*;
import javax.swing.*;
import java.awt.event.*;

public class Account extends JApplet implements ActionListener
{
    private Button submitBtn;
    private Label titleLbl;
    private Label nameLbl;
    private Label emailLbl;
    private Label passwdLbl;
    private Label conpwdLbl;
    private TextField nameText;
    private TextField emailText;
    private TextField pwdText;
    private TextField conpwdText;
    private TextField component = null;

    private String Message = null;

    public void init()
    {
      titleLbl = new Label("New Account");
      titleLbl.setFont(new java.awt.Font("Tahoma", 1, 18)); // NOI18N
      nameLbl = new Label("Name");
      emailLbl = new Label("Email Address");
      passwdLbl = new Label("Password");
      conpwdLbl = new Label("Confirm Password");
      nameText = new TextField(15);
      emailText = new TextField(15);
      pwdText = new TextField(15);
      pwdText.setEchoChar('*');
      conpwdText = new TextField(15);
      conpwdText.setEchoChar('*');

      submitBtn = new Button("Submit");
      submitBtn.setPreferredSize(new Dimension(100, 25));

      Container cp = getContentPane();
      cp.setLayout(new GridBagLayout());
      GridBagConstraints gbc = new GridBagConstraints();
      gbc.anchor = GridBagConstraints.WEST;
      gbc.insets = new Insets(5,0,5,5);

      gbc.gridwidth = GridBagConstraints.RELATIVE;
      cp.add(nameLbl,gbc);
      gbc.gridwidth = GridBagConstraints.REMAINDER;
      cp.add(nameText,gbc);

      gbc.gridwidth = GridBagConstraints.RELATIVE;
      cp.add(emailLbl,gbc);
      gbc.gridwidth = GridBagConstraints.REMAINDER;
      cp.add(emailText,gbc);

      gbc.gridwidth = GridBagConstraints.RELATIVE;
      cp.add(passwdLbl,gbc);
      gbc.gridwidth = GridBagConstraints.REMAINDER;
      cp.add(pwdText,gbc);

      gbc.gridwidth = GridBagConstraints.RELATIVE;
      cp.add(conpwdLbl,gbc);
      gbc.gridwidth = GridBagConstraints.REMAINDER;
      cp.add(conpwdText,gbc);

      gbc.gridwidth = GridBagConstraints.SOUTH;
      Panel bottom = new Panel();
      bottom.add(submitBtn);
      gbc.anchor = GridBagConstraints.CENTER;
      cp.add(bottom,gbc);

      submitBtn.addActionListener(this);
    }

    // Method called by Java Script applet object to send infomation to the applet.
    public boolean isParamsValid()
    {
      boolean flag = false;
      
      if(nameText.getText() == null || nameText.getText().equals(""))
      {
  	Message = "User Name not entered";
        component = nameText;
      }
      else if(nameText.getText().length() > 15)
      {
        Message = "User Name out of bounds";
        component = nameText;
      }
      else if(emailText.getText() == null || emailText.getText().equals(""))
      {
  	Message = "Email Address not entered";
        component = emailText;
      }
      else if(emailText.getText().length() > 25)
      {
        Message = "Email Address out of bounds";
        component = emailText;
      }
      else if(!Validator.isEmailValid(emailText.getText()))
      {
        Message = "Invalid Email Address";
        component = emailText;
      }
      else if(pwdText.getText() == null || pwdText.getText().equals(""))
      {
  	Message = "Password not entered";
        component = pwdText;
      }
      else if(pwdText.getText().length() > 15)
      {
        Message = "Password out of bounds";
        component = pwdText;
      }
      else if(conpwdText.getText() == null  || conpwdText.getText().equals(""))
      {
  	Message = "Confirm Password not entered";
        component = conpwdText;
      }
      else if(conpwdText.getText().length() > 15)
      {
        Message = "Confirm Password out of bounds";
        component = conpwdText;
      }
      else if(!(pwdText.getText()).equals(conpwdText.getText()))
      {
        Message = "Password is not equal to confirm password";
        component = conpwdText;
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
      String msg= "name=" + nameText.getText() + "&email=" + emailText.getText() +
                  "&passwd=" + pwdText.getText() + "&vericode=" + Integer.toString(veriCode);

      return msg;
    }

    public void actionPerformed(ActionEvent e) {

      boolean redirect = false;
      submitBtn.setEnabled(false);

      try
      {
        if(isParamsValid())
        {
          byte[] msgAsBytes = getParams().getBytes();

          URL url = this.getCodeBase();
          url = new URL(url + "account.php");
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
	    if(!aLine.equals("")) {

              if(msgid == JOptionPane.PLAIN_MESSAGE) {
                if(aLine.equals("accerror")) {
                    msgid = JOptionPane.ERROR_MESSAGE;
                    title = "Registration Error";
                }
                else if (aLine.equals("accinvalid")) {
                    msgid = JOptionPane.ERROR_MESSAGE;
                    title = "Invalid Request";
                }
                else if (aLine.equals("accsuccess")) {
                    msgid = JOptionPane.INFORMATION_MESSAGE;
                    title = "Registration Success";
                }
                else {
 	          textBuffer = textBuffer + aLine + '\n';
                }
              }
              else {
	        textBuffer = textBuffer + aLine + '\n';

                if(aLine.contains("Registration completed successfully !!"))
                  redirect = true;
              }
            }
          }

          JOptionPane.showMessageDialog(null, textBuffer, title, msgid);
          in.close();
          oStream.close();

          if(redirect) {
            URL u = this.getCodeBase();
            URL ul = new URL(u + "message.php?msgid=accsuccess");
            this.getAppletContext().showDocument(ul);
          }
          else {
            submitBtn.setEnabled(true);
          }
        }
        else
        {
          if(Message != null)
            JOptionPane.showMessageDialog(null, Message, "Invalid Field", JOptionPane.ERROR_MESSAGE);
		   
	  if(component!= null) {
            component.requestFocusInWindow();
	  }

          submitBtn.setEnabled(true);
        }
      }
      catch(Exception ex) {
        JOptionPane.showMessageDialog(null, ex.getMessage(), "Exception", JOptionPane.ERROR_MESSAGE);
      }
    }
}

