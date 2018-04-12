using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

/// <summary>
/// Author: Zachary Mitchell
/// This is designed as a simple program that does an encryption check. Basically: if the input from argument 1 unlocks argument 2, then return true.
/// The program can also check from a file to check a list of encrypted strings; if one gets decrypted, then return true.
/// 
/// To actually encrypt items, run the -e flag; this will output a string that can only be unlocked through the input. It can also be saved to a file using -f ["filename"]
/// </summary>
namespace scramblerVerify
{
    class Program
    {
        static bool help = false;

        //This is having issues from the command-line side... If you want to try your hand at this problem, set this program to a "Windows Application" in properties.

        //This is needed to blend the command prompt and gui together.
        //It was basically taken directly from: https://stackoverflow.com/questions/7198639/c-sharp-application-both-gui-and-commandline
        /*[DllImport("kernel32.dll")]
        static extern bool AttachConsole(int dwProcessId);
        private const int ATTACH_PARENT_PROCESS = -1;*/

        [STAThread]
        static void Main(string[] args)
        {
            //AttachConsole(ATTACH_PARENT_PROCESS);
            string usage = "Usage:\n\nEncrypting: scramblerVerify.exe -e password [password2] [password3] [-f ./path/to/textFile]\nDecrypting: ./scramblerVerify.exe password scrambledString [scrambledString2] [scrambledString3] [-f ./path/to/textFile.txt]\n\nThis program can check a password amongst a \"database\" of phrases that only unlock with said password.\n\nSee included README.MD for more information.";

            bool gotFirstWord = false;
            bool purgeOk = false;

            //Grabbing the flags and arguments
            for(int i = 0; i < args.Length; i++)
            {
                switch (args[i])
                {
                    case "-e":
                        setup.encrypt = true;
                        break;
                    case "-E":
                        setup.encrypt = true;
                        setup.verbose = true;
                        break;
                    case "-d":
                        setup.decrypt = true;
                        break;
                    case "-f":
                        try {
                            setup.saveLocation = args[i + 1];
                            setup.useFile = true;
                            purgeOk = true;
                        }
                        catch (IndexOutOfRangeException)
                        {
                            Console.WriteLine("Error: No option given for the source file! Proceeding without an external file...");
                        }
                        break;
                    case "-Z":
                        setup.purge = true;
                        try
                        {
                            if (setup.useFile || System.IO.File.Exists(args[i + 1]))
                            {
                                setup.saveLocation = args[i + 1];
                                purgeOk = true;
                            }
                        }
                        catch (IndexOutOfRangeException)
                        {
                        }
                        break;
                    case "-r":
                        setup.removeWord = true;
                        break;
                    case "-p":
                        setup.replaceWord = true;
                        break;
                    case "-h":
                        help = true;
                        break;
                    default:
                        if (args[i] != setup.saveLocation)
                        {
                            if (!gotFirstWord)
                            {
                                setup.compare = args[i];
                                gotFirstWord = true;
                            }
                            else setup.wordList.Add(args[i]);
                        }
                        break;
                }
            }

            //Checking for spaces:
            bool spaces = false;
            foreach(string argument in args)
            {
                if (argument != setup.saveLocation)
                {
                    foreach (char character in argument)
                    {
                        if (character == ' ')
                        {
                            spaces = true;
                            break;
                        }
                    }
                }
            }

            if(setup.encrypt || setup.removeWord)
                setup.wordList.Add(setup.compare);

            if (help)
            {
                Console.WriteLine(usage);
            }
            else if (spaces)
                Console.WriteLine("Scrambler Verify: this program does not accept spaces in any argument.");

            else if (setup.purge && !purgeOk)
                Console.WriteLine("Error: No option given for the source file! See README.MD for more information on clearing a file.");
            else
            {
                string output = setup.execute();
                if (output == null)
                {
                    //Start the gui!
                    Console.WriteLine("scramblerVerify: The GUI is starting! If this wasn't intended, kill me with \"taskkill /IM scramblerVerify.exe\" (If you launched this in the command prompt, use CTRL + C)\n\nFor help, use \"scramblerVerify.exe -h\"");
                    Application.EnableVisualStyles();
                    Application.SetCompatibleTextRenderingDefault(false);
                    Application.Run(new guiMain());
                }
                else Console.Write(output);
            }
        }

    }
}
