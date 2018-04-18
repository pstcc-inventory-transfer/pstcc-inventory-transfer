Scrambler verify
================

This is a program to help with security. It checks to see if a string can unscramble an encrypted piece of text (built in to the program); if successful, it prints "True" to the command line.

## Usage:
 
## GUI
If no arguments are provided while launching this executable, an easy-to-use Graphical user interface will appear. This is designed to do all the features below through point and click. While it's usefull in many cases, if you need to programatically add,delete, or change passwords, see the command line flags below.

### Encrypting
 ```./scramblerVerify.exe {-e,-E} password [anotherPassword] [ANOTHERpassword:O] [-f ./path/to/textFile.txt]```

 **WHERE:**

**-e** is the encryption flag. it scrambles the built-in string with the specified password, then outputs the scrambled string to the command line. If you specify more passwords, it will also output those strings as well.

**-E** is the same as the above, except that the output is *Human readable*. This option is good to make sure you don't miss something like a tab if you choose to copy or paste the phrase instead. The output might look something like this:
```.\scramblerVerify.exe -E password123
Phrase: '¢Z¢_~^¡HxVEatkW^Ys$m\Oz@¿au<xlu^r`!'```

**-f** allows you to save the scrambled string(s) into the file of your choice.

### Decrypting
```./scramblerVerify.exe -d password scrambledString [scrambledString2] [scrambledString3] [-f ./path/to/textFile.txt]```

**WHERE:**

**-f** tells the program you wish to compare "password" to that file. It looks through all other scrambled strings in that file, and if nothing can get unscrambled, it returns "False".

When decrypting, the first argument is always the password you want to use to unscramble the second argument, as well as any other scrambled arguments provided. You can request *both* an external file, and scrambled arguments to be compared at the same time.

### Removing a "password"
Passwords do **not** get stored in this program, just scrambled text that can be unscrabled with that password. If you wish to remove a reference to such a password (The password will no longer return true), use the following:

```./scramblerVerify.exe -r password1 [password2] [passEtc] -f ./path/to/textFile.txt```

**WHERE**

**-r** represents *remove*. Use this to remove the requested password reference.

You can remove multiple references to passcodes at once (as represented by password1,etc.)

### Changing a "passowrd"
If you would like to replace a "password" with another, do so with the following command;
```/.scramblerVerify.exe -p oldPass newPass -f ./path/to/textFile.txt```

**WHERE**
**-p** stands for *rePlace*. This flag tells the program that the first word is the second's replacement, and saves accordingly. If The first word doesn't exhist, the program outputs "notfound".

### Clearing the file
If for some reason you need to clear out the file that contains the "passwords", the following command will empty the file, but not delete it:
```./scramblerVerify.exe -Z ./path/to/textFile.txt```
**WHERE**
**-Z** is the flag that says "clear out the file". It does not accept any arguments.