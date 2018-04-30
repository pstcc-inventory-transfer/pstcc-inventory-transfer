namespace scramblerVerify
{
    partial class guiMain
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.fileTextBox = new System.Windows.Forms.TextBox();
            this.fileSelectButton = new System.Windows.Forms.Button();
            this.inputBox = new System.Windows.Forms.TextBox();
            this.modeGroup = new System.Windows.Forms.GroupBox();
            this.replaceRadio = new System.Windows.Forms.RadioButton();
            this.compareRadio = new System.Windows.Forms.RadioButton();
            this.removeRadio = new System.Windows.Forms.RadioButton();
            this.addEncryptRadio = new System.Windows.Forms.RadioButton();
            this.invalidPathLabel = new System.Windows.Forms.Label();
            this.knownPhrases = new System.Windows.Forms.ListBox();
            this.phrasesLabel = new System.Windows.Forms.Label();
            this.outputBox = new System.Windows.Forms.RichTextBox();
            this.executeButton = new System.Windows.Forms.Button();
            this.openFileDialog1 = new System.Windows.Forms.OpenFileDialog();
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.fileToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.newFileToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.clearToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.inputBox2 = new System.Windows.Forms.TextBox();
            this.saveFileDialog1 = new System.Windows.Forms.SaveFileDialog();
            this.inputLabel = new System.Windows.Forms.Label();
            this.input2Label = new System.Windows.Forms.Label();
            this.modeGroup.SuspendLayout();
            this.menuStrip1.SuspendLayout();
            this.SuspendLayout();
            // 
            // fileTextBox
            // 
            this.fileTextBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.fileTextBox.Location = new System.Drawing.Point(118, 37);
            this.fileTextBox.Name = "fileTextBox";
            this.fileTextBox.Size = new System.Drawing.Size(202, 20);
            this.fileTextBox.TabIndex = 0;
            this.fileTextBox.KeyDown += new System.Windows.Forms.KeyEventHandler(this.fileTextBox_KeyDown);
            this.fileTextBox.Leave += new System.EventHandler(this.fileTextBox_Leave);
            // 
            // fileSelectButton
            // 
            this.fileSelectButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.fileSelectButton.Location = new System.Drawing.Point(326, 35);
            this.fileSelectButton.Name = "fileSelectButton";
            this.fileSelectButton.Size = new System.Drawing.Size(84, 23);
            this.fileSelectButton.TabIndex = 1;
            this.fileSelectButton.Text = "Choose File...";
            this.fileSelectButton.UseVisualStyleBackColor = true;
            this.fileSelectButton.Click += new System.EventHandler(this.fileSelectButton_Click);
            // 
            // inputBox
            // 
            this.inputBox.AcceptsReturn = true;
            this.inputBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.inputBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.inputBox.Location = new System.Drawing.Point(118, 76);
            this.inputBox.Multiline = true;
            this.inputBox.Name = "inputBox";
            this.inputBox.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.inputBox.Size = new System.Drawing.Size(299, 145);
            this.inputBox.TabIndex = 2;
            this.inputBox.MultilineChanged += new System.EventHandler(this.inputBox_MultilineChanged);
            this.inputBox.TextChanged += new System.EventHandler(this.inputBox_TextChanged);
            // 
            // modeGroup
            // 
            this.modeGroup.Controls.Add(this.replaceRadio);
            this.modeGroup.Controls.Add(this.compareRadio);
            this.modeGroup.Controls.Add(this.removeRadio);
            this.modeGroup.Controls.Add(this.addEncryptRadio);
            this.modeGroup.Location = new System.Drawing.Point(22, 35);
            this.modeGroup.Name = "modeGroup";
            this.modeGroup.Size = new System.Drawing.Size(89, 185);
            this.modeGroup.TabIndex = 3;
            this.modeGroup.TabStop = false;
            this.modeGroup.Text = "Current Mode";
            // 
            // replaceRadio
            // 
            this.replaceRadio.AutoSize = true;
            this.replaceRadio.Enabled = false;
            this.replaceRadio.Location = new System.Drawing.Point(6, 149);
            this.replaceRadio.Name = "replaceRadio";
            this.replaceRadio.Size = new System.Drawing.Size(65, 17);
            this.replaceRadio.TabIndex = 2;
            this.replaceRadio.Text = "Replace";
            this.replaceRadio.UseVisualStyleBackColor = true;
            this.replaceRadio.CheckedChanged += new System.EventHandler(this.alterTextBoxes);
            // 
            // compareRadio
            // 
            this.compareRadio.AutoSize = true;
            this.compareRadio.Location = new System.Drawing.Point(6, 69);
            this.compareRadio.Name = "compareRadio";
            this.compareRadio.Size = new System.Drawing.Size(67, 17);
            this.compareRadio.TabIndex = 1;
            this.compareRadio.Text = "Compare";
            this.compareRadio.UseVisualStyleBackColor = true;
            this.compareRadio.CheckedChanged += new System.EventHandler(this.alterTextBoxes);
            // 
            // removeRadio
            // 
            this.removeRadio.AutoSize = true;
            this.removeRadio.Enabled = false;
            this.removeRadio.Location = new System.Drawing.Point(6, 109);
            this.removeRadio.Name = "removeRadio";
            this.removeRadio.Size = new System.Drawing.Size(65, 17);
            this.removeRadio.TabIndex = 1;
            this.removeRadio.Text = "Remove";
            this.removeRadio.UseVisualStyleBackColor = true;
            this.removeRadio.CheckedChanged += new System.EventHandler(this.alterTextBoxes);
            // 
            // addEncryptRadio
            // 
            this.addEncryptRadio.AutoSize = true;
            this.addEncryptRadio.Checked = true;
            this.addEncryptRadio.Location = new System.Drawing.Point(6, 29);
            this.addEncryptRadio.Name = "addEncryptRadio";
            this.addEncryptRadio.Size = new System.Drawing.Size(61, 17);
            this.addEncryptRadio.TabIndex = 0;
            this.addEncryptRadio.TabStop = true;
            this.addEncryptRadio.Text = "Encrypt";
            this.addEncryptRadio.UseVisualStyleBackColor = true;
            this.addEncryptRadio.CheckedChanged += new System.EventHandler(this.alterTextBoxes);
            // 
            // invalidPathLabel
            // 
            this.invalidPathLabel.AutoSize = true;
            this.invalidPathLabel.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.invalidPathLabel.ForeColor = System.Drawing.Color.Firebrick;
            this.invalidPathLabel.Location = new System.Drawing.Point(135, 18);
            this.invalidPathLabel.Name = "invalidPathLabel";
            this.invalidPathLabel.Size = new System.Drawing.Size(139, 13);
            this.invalidPathLabel.TabIndex = 4;
            this.invalidPathLabel.Text = "This file doesn\'t exist...";
            this.invalidPathLabel.Visible = false;
            // 
            // knownPhrases
            // 
            this.knownPhrases.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.knownPhrases.FormattingEnabled = true;
            this.knownPhrases.Location = new System.Drawing.Point(433, 60);
            this.knownPhrases.Name = "knownPhrases";
            this.knownPhrases.Size = new System.Drawing.Size(78, 225);
            this.knownPhrases.TabIndex = 5;
            this.knownPhrases.DoubleClick += new System.EventHandler(this.knownPhrases_DoubleClick);
            // 
            // phrasesLabel
            // 
            this.phrasesLabel.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.phrasesLabel.AutoSize = true;
            this.phrasesLabel.Location = new System.Drawing.Point(430, 35);
            this.phrasesLabel.Name = "phrasesLabel";
            this.phrasesLabel.Size = new System.Drawing.Size(81, 13);
            this.phrasesLabel.TabIndex = 6;
            this.phrasesLabel.Text = "Known Phrases";
            // 
            // outputBox
            // 
            this.outputBox.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.outputBox.BackColor = System.Drawing.Color.White;
            this.outputBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.outputBox.Location = new System.Drawing.Point(21, 227);
            this.outputBox.Name = "outputBox";
            this.outputBox.ReadOnly = true;
            this.outputBox.ScrollBars = System.Windows.Forms.RichTextBoxScrollBars.ForcedVertical;
            this.outputBox.Size = new System.Drawing.Size(406, 97);
            this.outputBox.TabIndex = 7;
            this.outputBox.Text = "";
            // 
            // executeButton
            // 
            this.executeButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.executeButton.Location = new System.Drawing.Point(433, 293);
            this.executeButton.Name = "executeButton";
            this.executeButton.Size = new System.Drawing.Size(78, 31);
            this.executeButton.TabIndex = 8;
            this.executeButton.Text = "Go";
            this.executeButton.UseVisualStyleBackColor = true;
            this.executeButton.Click += new System.EventHandler(this.executeButton_Click);
            // 
            // openFileDialog1
            // 
            this.openFileDialog1.FileName = "openFileDialog1";
            this.openFileDialog1.FileOk += new System.ComponentModel.CancelEventHandler(this.openFileDialog1_FileOk);
            // 
            // menuStrip1
            // 
            this.menuStrip1.BackColor = System.Drawing.SystemColors.Control;
            this.menuStrip1.ImageScalingSize = new System.Drawing.Size(24, 24);
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.fileToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(519, 24);
            this.menuStrip1.TabIndex = 9;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // fileToolStripMenuItem
            // 
            this.fileToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.newFileToolStripMenuItem,
            this.clearToolStripMenuItem});
            this.fileToolStripMenuItem.Name = "fileToolStripMenuItem";
            this.fileToolStripMenuItem.Size = new System.Drawing.Size(37, 20);
            this.fileToolStripMenuItem.Text = "File";
            // 
            // newFileToolStripMenuItem
            // 
            this.newFileToolStripMenuItem.Name = "newFileToolStripMenuItem";
            this.newFileToolStripMenuItem.Size = new System.Drawing.Size(119, 22);
            this.newFileToolStripMenuItem.Text = "New File";
            this.newFileToolStripMenuItem.Click += new System.EventHandler(this.newFileToolStripMenuItem_Click);
            // 
            // clearToolStripMenuItem
            // 
            this.clearToolStripMenuItem.Enabled = false;
            this.clearToolStripMenuItem.Name = "clearToolStripMenuItem";
            this.clearToolStripMenuItem.Size = new System.Drawing.Size(119, 22);
            this.clearToolStripMenuItem.Text = "Clear";
            this.clearToolStripMenuItem.Click += new System.EventHandler(this.clearToolStripMenuItem_Click);
            // 
            // inputBox2
            // 
            this.inputBox2.AcceptsReturn = true;
            this.inputBox2.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.inputBox2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.inputBox2.Location = new System.Drawing.Point(119, 118);
            this.inputBox2.Multiline = true;
            this.inputBox2.Name = "inputBox2";
            this.inputBox2.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.inputBox2.Size = new System.Drawing.Size(299, 103);
            this.inputBox2.TabIndex = 10;
            this.inputBox2.Visible = false;
            this.inputBox2.MultilineChanged += new System.EventHandler(this.inputBox2_MultilineChanged);
            this.inputBox2.TextChanged += new System.EventHandler(this.inputBox2_TextChanged);
            // 
            // saveFileDialog1
            // 
            this.saveFileDialog1.DefaultExt = "txt";
            this.saveFileDialog1.FileOk += new System.ComponentModel.CancelEventHandler(this.saveFileDialog1_FileOk);
            // 
            // inputLabel
            // 
            this.inputLabel.AutoSize = true;
            this.inputLabel.Location = new System.Drawing.Point(117, 60);
            this.inputLabel.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.inputLabel.Name = "inputLabel";
            this.inputLabel.Size = new System.Drawing.Size(56, 13);
            this.inputLabel.TabIndex = 11;
            this.inputLabel.Text = "inputLabel";
            // 
            // input2Label
            // 
            this.input2Label.AutoSize = true;
            this.input2Label.Location = new System.Drawing.Point(115, 101);
            this.input2Label.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.input2Label.Name = "input2Label";
            this.input2Label.Size = new System.Drawing.Size(62, 13);
            this.input2Label.TabIndex = 12;
            this.input2Label.Text = "input2Label";
            // 
            // guiMain
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(519, 336);
            this.Controls.Add(this.input2Label);
            this.Controls.Add(this.inputLabel);
            this.Controls.Add(this.inputBox2);
            this.Controls.Add(this.inputBox);
            this.Controls.Add(this.executeButton);
            this.Controls.Add(this.outputBox);
            this.Controls.Add(this.phrasesLabel);
            this.Controls.Add(this.knownPhrases);
            this.Controls.Add(this.invalidPathLabel);
            this.Controls.Add(this.modeGroup);
            this.Controls.Add(this.fileSelectButton);
            this.Controls.Add(this.fileTextBox);
            this.Controls.Add(this.menuStrip1);
            this.MainMenuStrip = this.menuStrip1;
            this.MinimumSize = new System.Drawing.Size(528, 302);
            this.Name = "guiMain";
            this.Text = "Scrambler Verify";
            this.modeGroup.ResumeLayout(false);
            this.modeGroup.PerformLayout();
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox fileTextBox;
        private System.Windows.Forms.Button fileSelectButton;
        private System.Windows.Forms.TextBox inputBox;
        private System.Windows.Forms.GroupBox modeGroup;
        private System.Windows.Forms.RadioButton replaceRadio;
        private System.Windows.Forms.RadioButton removeRadio;
        private System.Windows.Forms.RadioButton addEncryptRadio;
        private System.Windows.Forms.Label invalidPathLabel;
        private System.Windows.Forms.RadioButton compareRadio;
        private System.Windows.Forms.ListBox knownPhrases;
        private System.Windows.Forms.Label phrasesLabel;
        private System.Windows.Forms.RichTextBox outputBox;
        private System.Windows.Forms.Button executeButton;
        private System.Windows.Forms.OpenFileDialog openFileDialog1;
        private System.Windows.Forms.MenuStrip menuStrip1;
        private System.Windows.Forms.ToolStripMenuItem fileToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem newFileToolStripMenuItem;
        private System.Windows.Forms.TextBox inputBox2;
        private System.Windows.Forms.SaveFileDialog saveFileDialog1;
        private System.Windows.Forms.Label inputLabel;
        private System.Windows.Forms.Label input2Label;
        private System.Windows.Forms.ToolStripMenuItem clearToolStripMenuItem;
    }
}