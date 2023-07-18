import sys

# Riempimento table Libro
# 11,Richard III,863050834-5,Chinese,2019,8

try:
    prova = (sys.argv[1] == 'not null')
except IndexError:
    print("Sintassi sbagliata, prova:\n " + sys.argv[0] + " --libro <nome-file-input>")
    exit(0)


if sys.argv[1] == '--libro':

    file_raw = open(sys.argv[2])
    line = file_raw.readline()
    while line:
        # print(line)
        splitted_line = line.split(',')

        print( "INSERT INTO Libro VALUES ("      + splitted_line[0]+ "," 
                                           + "'" + splitted_line[2] + "',"
                                                 + splitted_line[5].strip() +  ");") 
        line = file_raw.readline()


# 198,   Split Second,   816886703-3,   Italian,  2012  ,4
if sys.argv[1] == '--isbn-info':

    file_raw = open(sys.argv[2])
    line = file_raw.readline()
    while line:
        # print(line)
        splitted_line = line.split(',')

        print( "INSERT INTO ISBN_Info VALUES ("      + "'" + splitted_line[2] + "',"
                                                     + "'" + splitted_line[1] + "',"
                                                     + "'" + splitted_line[3] + "',"
                                                           + splitted_line[4] +  ");") 
        line = file_raw.readline()





if sys.argv[1] == '--autore':

    file_raw = open(sys.argv[2])
    line = file_raw.readline()
    while line:
        # print(line)
        splitted_line = line.split(',')

        print( "INSERT INTO Autore VALUES ("      + splitted_line[0]+ "," 
                                           + "'" + splitted_line[1] + "',"
                                           + "'" + splitted_line[2] + "',"
                                           + "DATE('"  + splitted_line[3] + "')" + "," 
                                           + "'" + splitted_line[4].strip() +  "');") 
        line = file_raw.readline()

# 11,5,88

if sys.argv[1] == '--libro-autore':

    file_raw = open(sys.argv[2])
    line = file_raw.readline()
    while line:
        # print(line)
        splitted_line = line.split(',')

        print( "INSERT INTO Scritto_Da VALUES ("      + splitted_line[0]+ "," 
                                                  + splitted_line[1]+ ","
                                                  + splitted_line[2].strip() +  ");") 
        line = file_raw.readline()

# 9,Scienze chimiche e farmaceutiche,Via Luigi Borsari,46,44121,Ferrara

if sys.argv[1] == '--succursale':

    file_raw = open(sys.argv[2])
    line = file_raw.readline()
    while line:
        # print(line)
        splitted_line = line.split(',')
        print( "INSERT INTO Succursale VALUES ("       + splitted_line[0]+ "," 
                                            + "'" + splitted_line[1] + "',"
                                            + "'" + splitted_line[2] + "',"
                                            + "'" + splitted_line[3] + "'," 
                                            +       splitted_line[4] + ","
                                            + "'" + splitted_line[5].strip() + "');") 
        line = file_raw.readline()