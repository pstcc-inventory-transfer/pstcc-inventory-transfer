using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
/// <summary>
/// Credits:
/// SMPT client created by: Microsoft
/// Encryption: Zachary Mitchell
/// File Author: Zachary Mitchell
/// 
/// This makes use of the SMTP class to send emails to the desired client, and from the receiver.
/// </summary>
namespace cliEmail
{
    class Program
    {
        public static string confDir = "";
        public static string htmlDir = "";
        private static string uuid = key.getKey();
        public static List<string> filesDir = new List<string>();
        public static bool help = false;

        public static string[] argList =
        {
            "-config",
            "-html",
            "-files",
            "-help"
        };

        public static string usage =
            "Usage: cliEmail.exe [-config path/to/econfFile] [-html path/to/htmlFile] [-files file1.* file2.* etc...]\n\n" +
            "This is an email client that when executed, sends a message written in html to all users from the requested .econf file.\n" +
            "To set up this program, create a configuration file with the bundled program (cliEmailConfig.exe), then create an html file that has the message you wish to send.\n\n" +
            "Options: \n\n-config\tThe configuration file."+
            "\n-html\tThe message being sent out to others."+
            "\n-files\tAny attachments desired to be sent out. There isn't a limit to how many attachments can be sent."+
            "\n-help\tShow this menu.\n\nIf -config or -html are not used while launching the program, the program will automatically use \"default.econf\" and \"default.html\" respectively. **If neither of these files are found, the message will not be sent due to the lack of information.**"+
            "\n\nWhen creating an html file, the first line of the file is always the subject.\n\nThe configuration file contains everything to send messages from the desired email address, and contains a list of everybody to send to. While you can speficy names of people with the email addresses, seeing these inputted names will vary depending on the email program receiving the letter (e.g, outlook can intelligently obtain names from a contact list instead of user-defined names in the config file.)";

        private static bool searchArgs(string input)
        {
            for(int i = 0; i < argList.Length; i++)
            {
                if (input == argList[i])
                    return true;
            }
            return false;
        }

        static void Main(string[] args)
        {
            //grab arguments:
            for (int i= 0;i<args.Length;i++)
            {
                switch (args[i])
                {
                    case "-config":
                        confDir = args[i + 1];
                    break;
                    case "-html":
                        htmlDir = args[i + 1];
                    break;
                    case "-files":
                        //grab all the files until we reach another argument:
                        int searchIndex = i+1;
                        while (searchIndex < args.Length && !searchArgs(args[searchIndex]))
                        {
                            //Console.WriteLine("program.cs:"+args[searchIndex]);
                            filesDir.Add(args[searchIndex]);
                            searchIndex++;
                        }
                    break;
                    case "-help":
                        help = true;
                        break;
                }
            }
            if (confDir == "")
                confDir = "./default.econf";
            if (htmlDir == "")
                htmlDir = "./default.html";
            //Let's test all file paths to see what exhists:
            bool fileError = false;
            string dirsNotFound = "";
            if (!help)
            {
                List<string> dirs = new List<string>(new string[] { confDir, htmlDir });
                dirs.AddRange(filesDir);
                foreach (string element in dirs)
                {
                    if (!File.Exists(element))
                    {
                        fileError = true;
                        dirsNotFound += element + "\n";
                    }
                }
            }

            if (help)
                Console.WriteLine(usage);
            else if (fileError)
                Console.WriteLine("Error: Could not find the following items:\n\n" + dirsNotFound + "\nType -help while launching this program for assistance.");
            else
            {
                try
                {
                    emailConfiguration eConfig = new emailConfiguration(load(confDir)); //Everything gets converted into a readable format for Microsoft's client

                    //Alright, now we need the html file used for the message:
                    StreamReader htmlIn = File.OpenText(htmlDir);
                    message htmlMessage = new message(htmlIn.ReadLine(), htmlIn.ReadToEnd());
                    //SEND THE THING!!!1!
                    email.sendMail(ref eConfig, ref htmlMessage, filesDir.ToArray());
                }
                catch (FileNotFoundException ex)
                {
                    Console.WriteLine(ex.ToString());
                }
                catch (IndexOutOfRangeException)
                {
                    Console.WriteLine("There was an error while trying to read the .econf file. You may wish to create a new one with \"cliEmailConfig.exe\" if problems persist...");
                }
            }
        }

        //The loooong process of decrypting everything:
        private static List<string> load(string path)
        {
            List<string> conf = new List<string>();
            StreamReader confIn = File.OpenText(path);
            string confStr = confIn.ReadToEnd();
            confIn.Close();
            //Decrypt the string based off of key.cs:
            conf.AddRange(mailEncrypt(uuid,confStr).Split('\n'));

            confStr = "";
            //Decrypt the string based off of user-password: (we sortof have to put the string back together :P)
            for(int i = 1; i < conf.Count(); i++)
            {
                confStr += conf[i] + (i == conf.Count() - 1 ?"":"\n");
            }
            string pass = conf[0];
            conf.Clear();
            //now we split the string AGAIN! (oi, that must be painful) >_<
            conf.AddRange(mailEncrypt(pass,confStr).Split('\n'));
            return conf;
        }

        public static string mailEncrypt(string uuid, string input)
        {
                input = Encrypt.reverse(input);
                input = Encrypt.fluctuate(false, Encrypt.reverse(uuid), input);
                input = Encrypt.scrambler(false, uuid, input);
                input = Encrypt.fluctuate(false, uuid, input);
            return input;
        }
    }
}
