using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Windows.Forms;
using System.IO.Ports;
using System.IO;

namespace sistProg
{

    public partial class Form1 : Form
    {
        string hamVeri;
        string[] veriler;
        string tarih, saat;
        string[] basliklar = {"Enlem: ", "Boylam: ", "Yükseklik: ", "Hız: ", "Yön: ", "Uydular: "};
        object[] baudRates = {300, 1200, 2400, 4800, 9600, 19200, 38400, 57600, 74880, 115200, 230400, 250000, 500000, 1000000, 2000000};
        string kayitYeri = "";

        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            textBox1.ReadOnly = true;
            button2.Enabled = false;            

            string[] ports = SerialPort.GetPortNames();
            foreach (string port in ports)
                comboBox1.Items.Add(port);

            comboBox2.Items.AddRange(baudRates);
            
            comboBox2.Text = serialPort1.BaudRate.ToString();

            serialPort1.DataReceived += new SerialDataReceivedEventHandler(serialPort1_DataReceived); //DataReceived eventi oluşturuluyor
        }

        private void serialPort1_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            hamVeri = serialPort1.ReadExisting();
            this.Invoke(new EventHandler(displayData_event));          
        }

        private void displayData_event(object sender, EventArgs e)
        {
            tarih = DateTime.Now.ToString("MM/dd/yyyy");
            saat = DateTime.Now.ToString("HH:mm");
            string enlem = "", boylam = "", yukseklik = "", hiz = "", yon = "", uydular = "";            
            string newLine = Environment.NewLine;            
            veriler = hamVeri.Split(',');          

            for (int i = 0; i < veriler.Length-1; i++)
            {    
                textBox1.Text +=  basliklar[i] + veriler[i] + newLine;
               
                if (i == (veriler.Length - 2)) textBox1.Text += "Tarih: " + tarih + newLine + "Saat: " + saat + newLine;

                switch (i)
                {
                    case 0: enlem     = veriler[i]; break;                        
                    case 1: boylam    = veriler[i]; break;    
                    case 2: yukseklik = veriler[i]; break;
                    case 3: hiz       = veriler[i]; break;
                    case 4: yon       = veriler[i]; break;
                    case 5: uydular   = veriler[i]; break;
                }                
            }
            textBox1.Text += newLine;

            if(checkBox1.Checked==true)
            {
                try
                {
                    File.WriteAllText(kayitYeri, textBox1.Text);

                    if (enlem != "" && boylam != "")
                        webBrowser1.Navigate("http://anadolurock.epizy.com/index.php?en=" + enlem + "&boy=" + boylam + "&yuk=" + yukseklik + "&hiz=" + hiz + "&yon=" + yon + "&uyd=" + uydular + "&trh=" + tarih + "&st=" + saat + "&gonder=KAYIT");


                    /*if (enlem != "" && boylam != "")
                        webBrowser1.Navigate("http://anadolurock.epizy.com/index.php?en=" + enlem + "&boy=" + boylam + "&yuk=" + yukseklik + "&hiz=" + hiz + "&yon=" + yon + "&uyd=" + uydular + "&trh=" + tarih + "&st=" + saat + "&gonder=KAYIT");

                    string filelocation = @"C:\Users\Ozan\Desktop\";
                    string filename = "data.txt";
                    System.IO.File.WriteAllText(filelocation + filename, textBox1.Text);*/
                }
                catch (Exception hata)
                {
                    MessageBox.Show(hata.Message, "Hata");
                }
            }
        }

        private void button4_Click(object sender, EventArgs e) // KAYIT YERİ SEÇİMİ
        {
            SaveFileDialog save = new SaveFileDialog();
            save.Title = "Kayıt Yeri";
            save.DefaultExt = "txt";
            save.Filter = "txt Dosyaları (*.txt)|*.txt|Tüm Dosyalar(*.*)|*.*";
            if (save.ShowDialog() == DialogResult.OK)
                kayitYeri = save.FileName;
        }

        private void button1_Click(object sender, EventArgs e) //BAŞLAT
        {
            try
            {
                serialPort1.PortName = comboBox1.Text;
                serialPort1.BaudRate = int.Parse(comboBox2.Text);
                serialPort1.Open();
                button2.Enabled = true;
                button1.Enabled = false;
                
                /*_serialPort = new SerialPort();
                _serialPort.PortName = "COM4";//Set your board COM
                _serialPort.BaudRate = 9600;
                _serialPort.Open();
                while (true)
                {
                    string a = _serialPort.ReadExisting();
                    textBox1.Text+=a;
                    Thread.Sleep(200);
                }*/
            }
            catch(Exception hata)
            {
                MessageBox.Show(hata.Message,"Hata");
            }
        }

        private void button2_Click(object sender, EventArgs e) //DURDUR
        {
            serialPort1.Close();           
            button2.Enabled = false;
            button1.Enabled = true;
        }

        private void Form1_FormClosed(object sender, FormClosedEventArgs e)
        {
            if (serialPort1.IsOpen) serialPort1.Close();
        }        

        private void button3_Click(object sender, EventArgs e) //Sıfırla
        {
            textBox1.ResetText();
        }

       

        
    }

    
}
