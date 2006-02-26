// FileReadTest.java
// Copyright 1998 DevDaily Interactive, Inc.  All Rights Reserved.

import java.io.*;

class ReadCSV { 

    //--------------------------------------------------< main >--------//

    public static void main (String[] args) {
        ReadCSV t = new ReadCSV();
        t.readMyFile();
    } 


    //--------------------------------------------< readMyFile >--------//

    void readMyFile() { 

        String record = null;
        int recCount = 0; 
        String stringSQL = "";

        try { 

            FileReader fr = new FileReader("grp_kwd_grp.csv");
            File outputFile = new File("grp_kwd_grp.sql");
            BufferedReader br = new BufferedReader(fr);
            FileWriter out = new FileWriter(outputFile);

            record = new String();
            while ((record = br.readLine()) != null) {
                stringSQL += "insert into m_lib_icpc_kwd_grp values (" + record +");\n";
                recCount++;
                System.out.println(recCount + ": " + record); 
            } 
            System.out.println(stringSQL); 
            out.write(stringSQL);
            out.close();
            fr.close();
            
        } catch (IOException e) { 
            // catch possible io errors from readLine()
           System.out.println("Uh oh, got an IOException error!");
           e.printStackTrace();
        }

    } // end of readMyFile()

} // end of class