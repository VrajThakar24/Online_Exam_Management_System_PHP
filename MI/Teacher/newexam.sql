DROP TABLE IF EXISTS `english`;
CREATE TABLE `english` (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                question TEXT NOT NULL,
                                option_a VARCHAR(255) NOT NULL,
                                option_b VARCHAR(255) NOT NULL,
                                option_c VARCHAR(255) NOT NULL,
                                option_d VARCHAR(255) NOT NULL,
                                correct CHAR(1) NOT NULL
                            );

INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which of the following is not a feature of Java?','Object-Oriented','Platform Independent','Pointer Manipulation','Robust','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which company originally developed Java?','Microsoft','Sun Microsystems','Oracle','IBM','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which of the following is used to run compiled Java programs?','JRE','JVM','JDK','JIT','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is the file extension of compiled Java classes?','.java','.class','.exe','.jar','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which method is the entry point of a Java program?','start()','init()','main()','run()','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is the default value of a local variable in Java?','0','null','Depends on the data type','No default value','D');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which keyword is used to inherit a class in Java?','this','super','extends','implements','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which of the following is not a Java primitive data type?','int','float','String','char','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which OOP concept refers to hiding internal details and showing only functionality?','Inheritance','Encapsulation','Polymorphism','Abstraction','D');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is the size of the int data type in Java?','2 bytes','4 bytes','8 bytes','Depends on OS','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which method is used to get the length of a string in Java?','size()','length()','getSize()','length','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which keyword is used to create an object in Java?','this','create','new','init','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is the parent class of all Java classes?','Object','Class','Base','Super','A');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which access modifier makes members accessible only within the same class?','public','private','protected','default','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which of the following is not part of OOP in Java?','Polymorphism','Inheritance','Encapsulation','Compilation','D');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is method overloading in Java?','Same name, different parameters','Overriding in subclass','Too many methods','None','A');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What is method overriding in Java?','Same name, different return types','Subclass redefines method','Writing the same method twice','None','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which keyword is used to call the parent class constructor?','this()','super()','parent()','base()','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('What does JDK stand for?','Java Deployment Kit','Java Development Kit','Java Distributed Kernel','Java Debugging Kit','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which package is automatically imported in every Java program?','java.util','java.lang','java.io','java.net','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which keyword is used to prevent a class from being inherited?','static','abstract','final','private','C');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which statement is true about constructors in Java?','Constructors must have return type','Constructor name same as class','Constructors cannot be overloaded','Constructors are private','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which is an example of a checked exception?','NullPointerException','IOException','ArithmeticException','ArrayIndexOutOfBoundsException','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which statement is true about \'this\' keyword?','Refers to parent class','Refers to current object','Refers to static members','None','B');
INSERT INTO `english` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('Which operator is used for concatenation of strings?','+','&','.','*','A');
