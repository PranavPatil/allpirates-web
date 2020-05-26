
import java.util.*;
import java.util.regex.*;

public class Validator
{
  public static boolean isAlphabet(String str)
  {
	int i=0;
	boolean flag = true;
	
	if(str == null)
	  return false;

    while(flag==true && i<str.length())
    {
      flag = Character.isLetter(str.charAt(i));
      i++;
    }

    return flag;
  }

 /*
 Email format: A valid email address will have following format:
         [\\w\\.-]+: Begins with word characters, (may include periods and hypens).
     @: It must have a '@' symbol after initial characters.
     ([\\w\\-]+\\.)+: '@' must follow by more alphanumeric characters (may include hypens.).
 This part must also have a "." to separate domain and subdomain names.
     [A-Z]{2,4}$ : Must end with two to four alaphabets.
 (This will allow domain names with 2, 3 and 4 characters e.g pa, com, net, wxyz)

 Examples: Following email addresses will pass validation
 abc@xyz.net; ab.c@tx.gov
 */

  public static boolean isEmailValid(String email)
  {
    boolean isValid = false;


    //Initialize reg ex for email.
    String expression = "^[\\w\\.-]+@([\\w\\-]+\\.)+[A-Z]{2,4}$";
    CharSequence inputStr = email;
    //Make the comparison case-insensitive.
    Pattern pattern = Pattern.compile(expression,Pattern.CASE_INSENSITIVE);
    Matcher matcher = pattern.matcher(inputStr);

    if(matcher.matches()) {
      isValid = true;
    }

    if(isValid) {
      String[] list = {"com","org","gov","net","usa","edu"};
      int indx = email.lastIndexOf('.');
      String substr = email.substring(indx+1);
      boolean flag = false;

      for(int j =0; j < list.length; j++)
      {
        if(substr.equalsIgnoreCase(list[j]))
          flag = true;
      }

      if(flag == false)
       isValid = false;
    }

    return isValid;
  }

  public static boolean isNameField(String str)
  {
    int i=0;
    boolean flag = true,space = true;
	
    if(str == null)
     return false;

    while(flag==true && i<str.length())
    {
      flag = Character.isLetter(str.charAt(i));
   	  
      if(flag)
      {
     	space = false;
      }
      else if(str.charAt(i) == ' ' && space==false)
      {
        flag = true;
        space = true;
      }
   	  
      i++;
      
      if(i == str.length() && str.charAt(i-1) == ' ')
       flag = false;
    }

    return flag;
  }

  public static boolean isValidField(String field)
  {
	int i=0;
	boolean flag = true;
	
	if(field == null)
	  return false;

	while(flag==true && i<field.length())
	{
	  char ch = field.charAt(i);
   	  flag = Character.isLetter(ch);
   	  
   	  if(flag == false)
   	  {
   	  	flag = Character.isDigit(ch);
   	  	
   	    if(flag == false)
   	    {
   	      if(ch == '_')
   	      {
   	      	flag = true;
   	      }
   	    }
   	  }

      i++;
	}
	
	return flag;
  }
}