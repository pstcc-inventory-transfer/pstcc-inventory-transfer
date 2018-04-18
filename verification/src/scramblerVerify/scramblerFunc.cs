using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;

namespace scramblerVerify
{
    static class scramblerFunc
    {
        //The actual thing that get's scrambled. The program NEVER stores passwords ;)
        //Most functions in this file kindof need this to work, sooooo take good care of it
       static string test = "theQuickBrownFoxJumpsOverTheLazyDog";
        public static string getTest()
        {
            return test;
        }

        public static string enDecrypt(bool encrypt, string input, string uuidGen, bool useEnter = true)
        {
            string uuid = Uuid.generate(new Random(Uuid.txt2PsudoRandom(uuidGen)), true);
            string result = input;
            if (encrypt)
            {
                result = Encrypt.scrambler(true, uuid, result);
                result = Encrypt.fluctuate(true, uuid, result, useEnter);
                result = Encrypt.reverse(result);
            }
            else
            {
                result = Encrypt.reverse(result);
                result = Encrypt.fluctuate(false, uuid, result, useEnter);
                result = Encrypt.scrambler(false, uuid, result);
            }
            return result;
        }

        public static void save(string location, string[] uuidGen, bool keepEverything, bool encryptEachline = true)
        {
            int i;
            List<string> everything = new List<string>();
            if (keepEverything)
                everything.AddRange(load(location));
            //Console.WriteLine(""+everything.Count());
            StreamWriter saveLocation = new StreamWriter(location);

            //Insert all input:
            for (i = 0; i < uuidGen.Length; i++)
            {
                everything.Add(encryptEachline ? enDecrypt(true, test, uuidGen[i], false) : uuidGen[i]);
            }
            //Gather it all together, and encrypt it once more for good measure:
            string output = "";
            for (i = 0; i < everything.Count(); i++)
            {
                output += everything[i] + (i == everything.Count() - 1 ? "" : "\n");
            }
            saveLocation.Write(output == ""?"":enDecrypt(true, output, Uuid.generate(new Random(Uuid.txt2PsudoRandom(test)), true)));
            saveLocation.Close();
        }

        public static void remove(string location, string[] uuidGen)
        {
            string[] everything = load(location);

            List<string> newList = new List<string>();
            //remake the list with the requested strings omitted:
            int j = 0;
            for (int i = 0; i < everything.Length; i++)
            {
                bool copy = false;
                for (j = 0; j < uuidGen.Length; j++)
                {
                    /*Console.Write("j: ["+j+"] "+uuidGen[j]);
                    Console.WriteLine(":"+enDecrypt(true, test, uuidGen[j],false)+" | save entry:"+everything[i]);*/
                    if (enDecrypt(true, test, uuidGen[j],false) == everything[i])
                    {
                        copy = true;
                        break;
                    }
                }
                if (!copy)
                {
                    newList.Add(everything[i]);
                }
            }
            //After sifting through all options, re-save:
            save(location, newList.ToArray(), false);
        }

        public static string[] load(string location)
        {
            string result = "";
            try
            {
                StreamReader reader = File.OpenText(location);
                result = reader.ReadToEnd();
                reader.Close();
                if (result != "")
                    result = enDecrypt(false, result, Uuid.generate(new Random(Uuid.txt2PsudoRandom(test)), true));
                else return new string[] { };
                //Console.WriteLine(result);
            }
            catch (FileNotFoundException ex)
            {
                return new string[] { };
            }
            return result.Split('\n');
        }

        public static bool search(string[] haystack, string uuidGen)
        {
            //Console.WriteLine("serch term: " + enDecrypt(true, needle, uuidGen, false)+"\n");
            foreach (string element in haystack)
            {
                //Console.WriteLine(element);
                if (enDecrypt(true, test, uuidGen, false) == element)
                    return true;
            }
            return false;
        }
        public static string[] replace(string replaceString, string searchWord, string[] wordList)
        {
            for (int i = 0; i < wordList.Length; i++)
            {
                if (enDecrypt(true, test, searchWord, false) == wordList[i])
                {
                    //Console.WriteLine("before:" + wordList[i]);
                    wordList[i] = enDecrypt(true, test, replaceString, false);
                    //Console.WriteLine("after:" + wordList[i]);
                    return wordList;
                }
            }
            return null;
        }

        //This is here for organization sake XP
        public static void purgeFile(string fileName)
        {
            StreamWriter purge = new StreamWriter(fileName);
            purge.Write("");
            purge.Close();
        }
    }
}
