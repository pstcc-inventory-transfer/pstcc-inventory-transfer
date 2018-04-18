using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace scramblerVerify
{
    //Program.cs got too big, so the project was split between this, and scramblerFunc.cs

    //This object simluates what happens in the command line, regardless if the user launches the gui or not (I know, slightly lazy, but also sortof cool XD)
    public static class setup
    {
        public static bool encrypt = false, useFile = false, removeWord = false, replaceWord = false, decrypt = false, purge = false, verbose = false;
        public static string saveLocation = "";
        public static List<string> wordList = new List<string>();
        public static string compare = "";

        //Restarts the "query". There's also the choice to load the setup object with a new flag on the fly as well.
        public static void reset(string flag = "", bool resetFile = true)
        {
            encrypt = false;
            useFile = (resetFile?false:useFile);
            removeWord = false;
            replaceWord = false;
            decrypt = false;
            purge = false;
            wordList.Clear();
            saveLocation = (resetFile?"":saveLocation);
            compare = "";

            switch (flag)
            {
                case "encrypt":
                    encrypt = true;
                    break;
                case "useFile":
                    useFile = true;
                    break;
                case "removeWord":
                    removeWord = true;
                    break;
                case "replaceWord":
                    replaceWord = true;
                    break;
                case "decrypt":
                    decrypt = true;
                    break;
                case "purge":
                    purge = true;
                    break;
            }
        }

        //execute figures out what the user actually wants based on the above bools evaluate out too (on the command line, these would be flags)
        //If there's nothing to do, return null instead of a response;
        public static string execute()
        {
            if (removeWord)
            {
                //Guessing this should be removed as well:
                scramblerFunc.remove(saveLocation, wordList.ToArray());
                return "";
            }
            else if (purge)
            {
                scramblerFunc.purgeFile(saveLocation);
                return "";
            }
            else if (replaceWord)
            {
                string[] fileList = scramblerFunc.load(saveLocation);
                //We only compare two different words: with the second word being the exhisting word we wish to replace with the first.
                string[] newList = scramblerFunc.replace(wordList[0], compare, fileList);
                if (newList == null)
                {
                    return "notfound\n";
                }
                else
                {
                    scramblerFunc.save(saveLocation, newList, false, false);
                    return "";
                }
            }
            else if (encrypt)
            {

                if (useFile)
                {
                    scramblerFunc.save(saveLocation, wordList.ToArray(), true);
                    return "";
                }
                else
                {
                    string result = "";
                    foreach (string word in wordList)
                    {
                        result+=(verbose?"Phrase: '":"")+(scramblerFunc.enDecrypt(true, scramblerFunc.getTest(), word, false)+(verbose?"'":"")+"\n");
                    }
                    return result;
                }
            }
            else if (decrypt)
            {
                if (useFile)
                    wordList.AddRange(scramblerFunc.load(saveLocation));
                if (scramblerFunc.search(wordList.ToArray(), compare))
                {
                    return ""+true+"\n";
                }
                else return ""+false+"\n";
            }
            else return null;
        }
    }
}
