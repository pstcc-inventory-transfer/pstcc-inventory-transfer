using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO;

namespace scramblerVerify
{
    public partial class guiMain : Form
    {
        char passChar = '●';
        string prevFile = "";
        public guiMain()
        {
            InitializeComponent();
            alterTextBoxes(null, null);
            knownPhrases.Items.Add("test");
            knownPhrases.Items.Remove("test");
        }

        public bool KnownPasswords(string[] words, bool addRemove = true)
        {
            bool success = false;
                for (int i = 0; i <words.Length; i++)
                {
                    bool ok = addRemove?true:false;
                    foreach (string element in knownPhrases.Items)
                    {
                    if (element == words[i])
                        ok = addRemove?false:true;
                    }
                if (ok)
                {
                    if(addRemove)
                        knownPhrases.Items.Add(words[i]);
                    else knownPhrases.Items.Remove(words[i]);
                    success = true;
                }
                }
            return success;
        }

        //Spaces are not allowed in this program; therefore, this blocks it:
        public void check4Spaces(ref TextBox box, KeyEventArgs e)
        {
            if(e.KeyCode == Keys.Space)
            {
                MessageBox.Show("You can not use spaces in a password/scrambled text.", "Scrambler Verify: Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                string old = box.Text;
                box.Text = "";
                foreach(char character in old)
                {
                    if (character != ' ')
                        box.Text += ""+character;
                }
            }
        }

        //This helps return a propper array from a textbox that annoyingly uses BOTH carrige returns and newlines:
        public string[] carrigeReturnFix(string input)
        {
            string[] words = input.Split('\n');
            for (int i = 0; i < words.Length; i++)
            {
                //Carrige returns want to chill out here as well... Here's a way to get rid of them:
                words[i] = words[i].Split('\r')[0];
            }
            return words;
        }

    //This is tied to all radio boxes in the "current mode" group box.
    public void alterTextBoxes(object sender, EventArgs e)
        {
            if (addEncryptRadio.Checked || removeRadio.Checked)
            {
                inputBox.Multiline = true;
                inputBox2.Visible = false;
                input2Label.Visible = false;
                inputLabel.Text = addEncryptRadio.Checked ? "Add the following items:" : "Remove the following items:";
                setup.reset(addEncryptRadio.Checked?"encrypt":"removeWord",false);
            }
            else if (compareRadio.Checked)
            {
                inputBox.Multiline = false;
                inputBox2.Visible = true;
                inputBox2.Multiline = true;
                input2Label.Visible = true;
                inputLabel.Text = "Search for this item:";
                input2Label.Text = "Scrambled values to compare: (not required if a file is opened)";
                setup.reset("decrypt",false);
            }
            else if (replaceRadio.Checked)
            {
                input2Label.Visible = true;
                inputBox.Multiline = false;
                inputBox2.Visible = true;
                inputBox2.Multiline = false;
                inputLabel.Text = "Replace this item...";
                input2Label.Text = "...with this item:";
                setup.reset("replaceWord",false);
            }
        }

        private void fileSelectButton_Click(object sender, EventArgs e)
        {
            openFileDialog1.ShowDialog();
        }

        private void openFileDialog1_FileOk(object sender, CancelEventArgs e)
        {
            fileTextBox.Text = openFileDialog1.FileName;
            fileTextBox_Leave(null, null);
        }

        private void fileTextBox_Leave(object sender, EventArgs e)
        {
            if (File.Exists(fileTextBox.Text))
            {
                invalidPathLabel.Visible = false;
                removeRadio.Enabled = true;
                replaceRadio.Enabled = true;
                addEncryptRadio.Text = "Add";
                setup.useFile = true;
                clearToolStripMenuItem.Enabled = true;
                setup.saveLocation = fileTextBox.Text;
                if (fileTextBox.Text != prevFile)
                    knownPhrases.Items.Clear();
                prevFile = fileTextBox.Text;
            }
            else
            {
                clearToolStripMenuItem.Enabled = false;
                invalidPathLabel.Visible = true;
                removeRadio.Enabled = false;
                replaceRadio.Enabled = false;
                addEncryptRadio.Text = "Encrypt";
                setup.useFile = false;
            }

            if (fileTextBox.Text == "")
                invalidPathLabel.Visible = false;
        }

        private void fileTextBox_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Enter)
                fileTextBox_Leave(null, null);
        }

        private void knownPhrases_DoubleClick(object sender, EventArgs e)
        {
            //As annoying as this is, the program needs to follow microsoft's habbits of using carrige return and newline...
            if (knownPhrases.Items.Count > 0)
                inputBox.Text = (inputBox.Multiline ? inputBox.Text+"\r\n" : "") + knownPhrases.Items[knownPhrases.SelectedIndex];
        }

        private void inputBox_MultilineChanged(object sender, EventArgs e)
        {
            inputBox.Text = carrigeReturnFix(inputBox.Text)[0];
        }

        private void newFileToolStripMenuItem_Click(object sender, EventArgs e)
        {
            saveFileDialog1.ShowDialog();
        }

        private void saveFileDialog1_FileOk(object sender, CancelEventArgs e)
        {
            System.IO.Stream yay = System.IO.File.Create(saveFileDialog1.FileName);
            yay.Close();
            fileTextBox.Text = saveFileDialog1.FileName;
            fileTextBox_Leave(null, null);
        }

        private void inputBox2_MultilineChanged(object sender, EventArgs e)
        {
            inputBox2.Text = carrigeReturnFix(inputBox2.Text)[0];
        }

        private void executeButton_Click(object sender, EventArgs e)
        {
            outputBox.SelectionFont = new Font("Consolas", 8, FontStyle.Bold);
            outputBox.SelectionColor = Color.Black;
            outputBox.AppendText(outputBox.Text == ""?"":"\n");
            string output = "";

            if (setup.encrypt)
            {
                outputBox.AppendText(addEncryptRadio.Text + ": ");
                if (addEncryptRadio.Text == "Encrypt")
                {
                    setup.useFile = false;
                }
                //Create an array based on the input field:
                setup.wordList.AddRange(carrigeReturnFix(inputBox.Text));


                output = setup.execute();

                outputBox.SelectionColor = Color.Lime;
                outputBox.AppendText("Operation successfull"+(setup.useFile && KnownPasswords(carrigeReturnFix(inputBox.Text)) ?"; added to known passcodes...":"")+"\n");

                if (output != "")
                {
                    outputBox.SelectionFont = new Font("Consolas", 8);
                    outputBox.SelectionColor = Color.Black;
                    outputBox.AppendText("Scrambled values:\n" + output);
                }
                setup.reset("encrypt",false);
            }

            if (setup.decrypt)
            {
                outputBox.AppendText(compareRadio.Text + ": ");
                outputBox.SelectionFont = new Font("Consolas", 8);

                setup.compare = inputBox.Text;
                setup.wordList.Clear();
                if (inputBox2.Text != "")
                {
                    setup.wordList.AddRange(carrigeReturnFix(inputBox2.Text));
                }

                output = setup.execute();

                if(output == "True\n")
                {
                    outputBox.SelectionColor = Color.Lime;
                    outputBox.AppendText("Found "+inputBox.Text+(setup.useFile && KnownPasswords(carrigeReturnFix(inputBox.Text)) ? "; added to known passcodes...":"")+"");
                }
                else
                {
                    outputBox.SelectionColor = Color.Red;
                    outputBox.AppendText("Operation Failed: Couldn't find "+inputBox.Text+"..." + (KnownPasswords(carrigeReturnFix(inputBox.Text),false)?" item removed from known passwords..":""));
                }
                setup.reset("decrypt",false);
            }

            if (setup.removeWord)
            {
                outputBox.AppendText(removeRadio.Text + ": ");
                outputBox.SelectionFont = new Font("Consolas", 8);

                setup.wordList.AddRange(carrigeReturnFix(inputBox.Text));
                setup.execute();
                outputBox.SelectionColor = Color.Lime;
                outputBox.AppendText("Operation successfull" + (KnownPasswords(carrigeReturnFix(inputBox.Text), false) ? "; Some items removed from known passwords..." : ""));
                setup.reset("removeWord",false);
            }

            if (setup.replaceWord)
            {
                outputBox.AppendText(replaceRadio.Text + ": ");
                outputBox.SelectionFont = new Font("Consolas", 8);

                setup.compare = inputBox.Text;
                setup.wordList.Add(inputBox2.Text);
                output = setup.execute();
                if(output == "notfound")
                {
                    outputBox.SelectionColor = Color.Red;
                    outputBox.AppendText("Error: "+inputBox.Text+" doesn't exist in this file."+(KnownPasswords(carrigeReturnFix(inputBox.Text), false)?" Item removed from list...":""));
                }
                else
                {
                    KnownPasswords(carrigeReturnFix(inputBox.Text), false);
                    outputBox.SelectionColor = Color.Lime;
                    outputBox.AppendText("Operation successfull" + (KnownPasswords(carrigeReturnFix(inputBox2.Text)) ? "; added/replaced item in known passwords..." : ""));
                }
            }
        }

        private void clearToolStripMenuItem_Click(object sender, EventArgs e)
        {
            DialogResult clearWindow = MessageBox.Show("Do want to start over in this file?","Scrambler Verify: Clear File",MessageBoxButtons.YesNo,MessageBoxIcon.Warning);
            if(clearWindow == DialogResult.Yes)
            {
                setup.purge = true;
                setup.execute();

                outputBox.AppendText(outputBox.Text == "" ? "" : "\n");
                outputBox.SelectionFont = new Font("Consolas", 8, FontStyle.Bold);
                outputBox.SelectionColor = Color.Black;
                outputBox.AppendText("Clear File: ");
                outputBox.SelectionFont = new Font("Consolas", 8);
                outputBox.SelectionColor = Color.Lime;
                outputBox.AppendText(" Operation Successful");
                alterTextBoxes(null, null);
            }
        }

        private void inputBox2_KeyDown(object sender, KeyEventArgs e)
        {
            check4Spaces(ref inputBox2, e);
        }

        private void inputBox_KeyDown(object sender, KeyEventArgs e)
        {
            check4Spaces(ref inputBox, e);
        }
    }
}
