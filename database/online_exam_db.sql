-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 01:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_exam_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_exams`
--

CREATE TABLE `available_exams` (
  `exam_name` varchar(255) DEFAULT NULL,
  `exam_date` datetime NOT NULL,
  `marks` int(11) NOT NULL,
  `exam_duration` time DEFAULT NULL,
  `subject_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_exams`
--

INSERT INTO `available_exams` (`exam_name`, `exam_date`, `marks`, `exam_duration`, `subject_id`) VALUES
('C# Programming', '2025-10-13 11:30:00', 20, '00:15:00', '501C'),
('Java Programming', '2025-10-15 13:30:00', 20, '00:15:00', '501B'),
('Python Programming', '2025-10-16 13:30:00', 20, '00:15:00', '401C'),
('Web Development', '2025-10-17 13:30:00', 20, '00:15:00', '301C'),
('java2', '2025-11-18 12:00:00', 20, '00:15:00', 'java'),
('java_3', '2026-03-26 11:38:00', 20, '00:15:00', 'java_3'),
('english', '2026-03-17 02:47:00', 80, '00:00:00', 'English_12');

-- --------------------------------------------------------

--
-- Table structure for table `available_results`
--

CREATE TABLE `available_results` (
  `result_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `exam_datetime` datetime NOT NULL,
  `total_marks` int(11) NOT NULL,
  `obtained_marks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_results`
--

INSERT INTO `available_results` (`result_id`, `username`, `exam_name`, `exam_datetime`, `total_marks`, `obtained_marks`) VALUES
(1, '202324114', 'C#_unit1', '2025-07-28 13:30:00', 20, 18),
(2, '202324127', 'C#_unit1', '2025-07-28 13:30:00', 20, 16),
(3, '202324114', 'Java_unit1', '2025-08-08 13:30:00', 20, 17),
(4, '202324127', 'Java_unit1', '2025-08-08 13:30:00', 20, 18),
(5, '202324114', 'C#_unit2', '2025-08-26 10:57:21', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `csharp_test1`
--

CREATE TABLE `csharp_test1` (
  `No` int(4) NOT NULL,
  `Question` varchar(100) NOT NULL,
  `A` varchar(50) NOT NULL,
  `B` varchar(50) NOT NULL,
  `C` varchar(50) NOT NULL,
  `D` varchar(50) NOT NULL,
  `Correct_Ans` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `csharp_test1`
--

INSERT INTO `csharp_test1` (`No`, `Question`, `A`, `B`, `C`, `D`, `Correct_Ans`) VALUES
(26, 'Which Visual Studio version first introduced .NET Core support?', '2010', '2015', '2017', '2022', '2017'),
(27, 'IntelliSense in Visual Studio is used for:', 'Debugging', 'Autocompleting code', 'Designing UI', 'Running code', 'Autocompleting code'),
(28, 'What is the default extension of a C# code file in Visual Studio?', '.c', '.cs', '.cpp', '.vb', '.cs'),
(29, 'Which of the following is NOT part of the Visual Studio IDE?', 'Command Prompt', 'Solution Explorer', 'Properties Window', 'Toolbox', 'Command Prompt'),
(30, 'The default method to add a new form to your project is:', 'Right-click > Add > New Item', 'File > Save As', 'Debug > Add', 'Tools > Insert Form', 'Right-click > Add > New Item'),
(31, 'Which window shows runtime errors and warnings in Visual Studio?', 'Toolbox', 'Error List', 'Output', 'Class View', 'Error List'),
(32, 'What is the file extension of a Windows Form Designer file?', '.cs', '.config', '.resx', '.Designer.cs', '.Designer.cs'),
(33, 'The shortcut to open Solution Explorer is:', 'Ctrl + S', 'Ctrl + Alt + L', 'Alt + E', 'Ctrl + Shift + T', 'Ctrl + Alt + L'),
(34, 'Visual Studio’s “Immediate Window” is used for:', 'Designing UI', 'Writing program', 'Testing code snippets at runtime', 'Debugging compile-time errors', 'Testing code snippets at runtime'),
(35, 'Which of the following helps group multiple projects in Visual Studio?', 'Form', 'Solution', 'File', 'Toolbox', 'Solution'),
(36, 'What is “Break Mode” in Visual Studio?', 'A setting to rest the application', 'Debugger paused execution', 'A shutdown mode', 'A view setting', 'Debugger paused execution'),
(37, 'What is the main purpose of a Debug build in Visual Studio?', 'Optimize performance', 'Remove all symbols', 'Include debugging info and checks', 'Publish application', 'Include debugging info and checks'),
(38, 'Which access modifier allows a member to be accessed within the same class only?', 'public', 'private', 'protected', 'internal', 'private'),
(39, 'Which keyword is used to inherit a class in C#?', 'base', 'derives', 'inherits', ': (colon)', ': (colon)'),
(40, 'What is the size of int data type in C#?', '2 bytes', '4 bytes', '8 bytes', 'Depends on system', '4 bytes'),
(41, 'Which C# keyword is used for creating an abstract class method?', 'override', 'new', 'abstract', 'base', 'abstract'),
(42, 'Which of these cannot be used with polymorphism in C#?', 'Method overriding', 'Interface', 'Constructor', 'Method overloading', 'Constructor'),
(43, 'What is the base class of all classes in C#?', 'Object', 'Class', 'Base', 'Parent', 'Object'),
(44, 'Which of the following is used for multiple inheritance in C#?', 'Class', 'Interface', 'Structure', 'Enum', 'Interface'),
(45, 'Which collection provides non-generic key-value pairs?', 'List', 'Dictionary', 'HashTable', 'Array', 'HashTable'),
(46, 'What is returned by a method that has no return type?', 'int', 'string', 'void', 'object', 'void'),
(47, 'What does the keyword static mean in C#?', 'Runs once only', 'Accessible only in main', 'Belongs to class', 'It’s a constant', 'Belongs to class'),
(48, 'Which loop is guaranteed to run at least once in C#?', 'for', 'foreach', 'while', 'do-while', 'do-while'),
(49, 'Which of the following is a reference type in C#?', 'int', 'float', 'double', 'string', 'string'),
(50, 'What is boxing in C#?', 'Value type to object', 'Object to value type', 'Hiding data', 'Inheriting class', 'Value type to object');

-- --------------------------------------------------------

--
-- Table structure for table `english`
--

CREATE TABLE `english` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `english`
--

INSERT INTO `english` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct`) VALUES
(1, 'Which of the following is not a feature of Java?', 'Object-Oriented', 'Platform Independent', 'Pointer Manipulation', 'Robust', 'C'),
(2, 'Which company originally developed Java?', 'Microsoft', 'Sun Microsystems', 'Oracle', 'IBM', 'B'),
(3, 'Which of the following is used to run compiled Java programs?', 'JRE', 'JVM', 'JDK', 'JIT', 'B'),
(4, 'What is the file extension of compiled Java classes?', '.java', '.class', '.exe', '.jar', 'B'),
(5, 'Which method is the entry point of a Java program?', 'start()', 'init()', 'main()', 'run()', 'C'),
(6, 'What is the default value of a local variable in Java?', '0', 'null', 'Depends on the data type', 'No default value', 'D'),
(7, 'Which keyword is used to inherit a class in Java?', 'this', 'super', 'extends', 'implements', 'C'),
(8, 'Which of the following is not a Java primitive data type?', 'int', 'float', 'String', 'char', 'C'),
(9, 'Which OOP concept refers to hiding internal details and showing only functionality?', 'Inheritance', 'Encapsulation', 'Polymorphism', 'Abstraction', 'D'),
(10, 'What is the size of the int data type in Java?', '2 bytes', '4 bytes', '8 bytes', 'Depends on OS', 'B'),
(11, 'Which method is used to get the length of a string in Java?', 'size()', 'length()', 'getSize()', 'length', 'B'),
(12, 'Which keyword is used to create an object in Java?', 'this', 'create', 'new', 'init', 'C'),
(13, 'What is the parent class of all Java classes?', 'Object', 'Class', 'Base', 'Super', 'A'),
(14, 'Which access modifier makes members accessible only within the same class?', 'public', 'private', 'protected', 'default', 'B'),
(15, 'Which of the following is not part of OOP in Java?', 'Polymorphism', 'Inheritance', 'Encapsulation', 'Compilation', 'D'),
(16, 'What is method overloading in Java?', 'Same name, different parameters', 'Overriding in subclass', 'Too many methods', 'None', 'A'),
(17, 'What is method overriding in Java?', 'Same name, different return types', 'Subclass redefines method', 'Writing the same method twice', 'None', 'B'),
(18, 'Which keyword is used to call the parent class constructor?', 'this()', 'super()', 'parent()', 'base()', 'B'),
(19, 'What does JDK stand for?', 'Java Deployment Kit', 'Java Development Kit', 'Java Distributed Kernel', 'Java Debugging Kit', 'B'),
(20, 'Which package is automatically imported in every Java program?', 'java.util', 'java.lang', 'java.io', 'java.net', 'B'),
(21, 'Which keyword is used to prevent a class from being inherited?', 'static', 'abstract', 'final', 'private', 'C'),
(22, 'Which statement is true about constructors in Java?', 'Constructors must have return type', 'Constructor name same as class', 'Constructors cannot be overloaded', 'Constructors are private', 'B'),
(23, 'Which is an example of a checked exception?', 'NullPointerException', 'IOException', 'ArithmeticException', 'ArrayIndexOutOfBoundsException', 'B'),
(24, 'Which statement is true about \'this\' keyword?', 'Refers to parent class', 'Refers to current object', 'Refers to static members', 'None', 'B'),
(25, 'Which operator is used for concatenation of strings?', '+', '&', '.', '*', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `java2`
--

CREATE TABLE `java2` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `java2`
--

INSERT INTO `java2` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct`) VALUES
(1, 'Which of the following is not a feature of Java?', 'Object-Oriented', 'Platform Independent', 'Pointer Manipulation', 'Robust', 'C'),
(2, 'Which company originally developed Java?', 'Microsoft', 'Sun Microsystems', 'Oracle', 'IBM', 'B'),
(3, 'Which of the following is used to run compiled Java programs?', 'JRE', 'JVM', 'JDK', 'JIT', 'B'),
(4, 'What is the file extension of compiled Java classes?', '.java', '.class', '.exe', '.jar', 'B'),
(5, 'Which method is the entry point of a Java program?', 'start()', 'init()', 'main()', 'run()', 'C'),
(6, 'What is the default value of a local variable in Java?', '0', 'null', 'Depends on the data type', 'No default value', 'D'),
(7, 'Which keyword is used to inherit a class in Java?', 'this', 'super', 'extends', 'implements', 'C'),
(8, 'Which of the following is not a Java primitive data type?', 'int', 'float', 'String', 'char', 'C'),
(9, 'Which OOP concept refers to hiding internal details and showing only functionality?', 'Inheritance', 'Encapsulation', 'Polymorphism', 'Abstraction', 'D'),
(10, 'What is the size of the int data type in Java?', '2 bytes', '4 bytes', '8 bytes', 'Depends on OS', 'B'),
(11, 'Which method is used to get the length of a string in Java?', 'size()', 'length()', 'getSize()', 'length', 'B'),
(12, 'Which keyword is used to create an object in Java?', 'this', 'create', 'new', 'init', 'C'),
(13, 'What is the parent class of all Java classes?', 'Object', 'Class', 'Base', 'Super', 'A'),
(14, 'Which access modifier makes members accessible only within the same class?', 'public', 'private', 'protected', 'default', 'B'),
(15, 'Which of the following is not part of OOP in Java?', 'Polymorphism', 'Inheritance', 'Encapsulation', 'Compilation', 'D'),
(16, 'What is method overloading in Java?', 'Same name, different parameters', 'Overriding in subclass', 'Too many methods', 'None', 'A'),
(17, 'What is method overriding in Java?', 'Same name, different return types', 'Subclass redefines method', 'Writing the same method twice', 'None', 'B'),
(18, 'Which keyword is used to call the parent class constructor?', 'this()', 'super()', 'parent()', 'base()', 'B'),
(19, 'What does JDK stand for?', 'Java Deployment Kit', 'Java Development Kit', 'Java Distributed Kernel', 'Java Debugging Kit', 'B'),
(20, 'Which package is automatically imported in every Java program?', 'java.util', 'java.lang', 'java.io', 'java.net', 'B'),
(21, 'Which keyword is used to prevent a class from being inherited?', 'static', 'abstract', 'final', 'private', 'C'),
(22, 'Which statement is true about constructors in Java?', 'Constructors must have return type', 'Constructor name same as class', 'Constructors cannot be overloaded', 'Constructors are private', 'B'),
(23, 'Which is an example of a checked exception?', 'NullPointerException', 'IOException', 'ArithmeticException', 'ArrayIndexOutOfBoundsException', 'B'),
(24, 'Which statement is true about \'this\' keyword?', 'Refers to parent class', 'Refers to current object', 'Refers to static members', 'None', 'B'),
(25, 'Which operator is used for concatenation of strings?', '+', '&', '.', '*', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `java_3`
--

CREATE TABLE `java_3` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `java_3`
--

INSERT INTO `java_3` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct`) VALUES
(1, 'Which of the following is not a feature of Java?', 'Object-Oriented', 'Platform Independent', 'Pointer Manipulation', 'Robust', 'C'),
(2, 'Which company originally developed Java?', 'Microsoft', 'Sun Microsystems', 'Oracle', 'IBM', 'B'),
(3, 'Which of the following is used to run compiled Java programs?', 'JRE', 'JVM', 'JDK', 'JIT', 'B'),
(4, 'What is the file extension of compiled Java classes?', '.java', '.class', '.exe', '.jar', 'B'),
(5, 'Which method is the entry point of a Java program?', 'start()', 'init()', 'main()', 'run()', 'C'),
(6, 'What is the default value of a local variable in Java?', '0', 'null', 'Depends on the data type', 'No default value', 'D'),
(7, 'Which keyword is used to inherit a class in Java?', 'this', 'super', 'extends', 'implements', 'C'),
(8, 'Which of the following is not a Java primitive data type?', 'int', 'float', 'String', 'char', 'C'),
(9, 'Which OOP concept refers to hiding internal details and showing only functionality?', 'Inheritance', 'Encapsulation', 'Polymorphism', 'Abstraction', 'D'),
(10, 'What is the size of the int data type in Java?', '2 bytes', '4 bytes', '8 bytes', 'Depends on OS', 'B'),
(11, 'Which method is used to get the length of a string in Java?', 'size()', 'length()', 'getSize()', 'length', 'B'),
(12, 'Which keyword is used to create an object in Java?', 'this', 'create', 'new', 'init', 'C'),
(13, 'What is the parent class of all Java classes?', 'Object', 'Class', 'Base', 'Super', 'A'),
(14, 'Which access modifier makes members accessible only within the same class?', 'public', 'private', 'protected', 'default', 'B'),
(15, 'Which of the following is not part of OOP in Java?', 'Polymorphism', 'Inheritance', 'Encapsulation', 'Compilation', 'D'),
(16, 'What is method overloading in Java?', 'Same name, different parameters', 'Overriding in subclass', 'Too many methods', 'None', 'A'),
(17, 'What is method overriding in Java?', 'Same name, different return types', 'Subclass redefines method', 'Writing the same method twice', 'None', 'B'),
(18, 'Which keyword is used to call the parent class constructor?', 'this()', 'super()', 'parent()', 'base()', 'B'),
(19, 'What does JDK stand for?', 'Java Deployment Kit', 'Java Development Kit', 'Java Distributed Kernel', 'Java Debugging Kit', 'B'),
(20, 'Which package is automatically imported in every Java program?', 'java.util', 'java.lang', 'java.io', 'java.net', 'B'),
(21, 'Which keyword is used to prevent a class from being inherited?', 'static', 'abstract', 'final', 'private', 'C'),
(22, 'Which statement is true about constructors in Java?', 'Constructors must have return type', 'Constructor name same as class', 'Constructors cannot be overloaded', 'Constructors are private', 'B'),
(23, 'Which is an example of a checked exception?', 'NullPointerException', 'IOException', 'ArithmeticException', 'ArrayIndexOutOfBoundsException', 'B'),
(24, 'Which statement is true about \'this\' keyword?', 'Refers to parent class', 'Refers to current object', 'Refers to static members', 'None', 'B'),
(25, 'Which operator is used for concatenation of strings?', '+', '&', '.', '*', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `signup_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `signup_active`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('202324114', 'DvkzlqC447', 'student'),
('202324127', 'QlnkloC45:', 'student'),
('202324131', 'QlvkdqwC464', 'student'),
('admin', 'DgplqC573<', 'admin'),
('misam_092', 'PlvdpC3<5', 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `username` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_details`
--

INSERT INTO `users_details` (`username`, `fullname`, `email`, `mobile_number`) VALUES
('202324114', 'Ashwin B Prajapati', 'abc12@gmail.com', 9500000095),
('202324127', 'Nikhil Rana', 'def34@gmail.com', 7900000079),
('202324131', 'Nishant Salvi', 'ghi56@gmail.com', 9800000098),
('admin', 'System Admin', 'jkl78@gmail.com', 9500000095),
('misam_092', 'Misam Nandoliya', 'mno90@gmail.com', 9000000090);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_exams`
--
ALTER TABLE `available_exams`
  ADD UNIQUE KEY `subject` (`exam_name`);

--
-- Indexes for table `available_results`
--
ALTER TABLE `available_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_username` (`username`);

--
-- Indexes for table `csharp_test1`
--
ALTER TABLE `csharp_test1`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `english`
--
ALTER TABLE `english`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `java2`
--
ALTER TABLE `java2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `java_3`
--
ALTER TABLE `java_3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_results`
--
ALTER TABLE `available_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `csharp_test1`
--
ALTER TABLE `csharp_test1`
  MODIFY `No` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `english`
--
ALTER TABLE `english`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `java2`
--
ALTER TABLE `java2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `java_3`
--
ALTER TABLE `java_3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `available_results`
--
ALTER TABLE `available_results`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_details`
--
ALTER TABLE `users_details`
  ADD CONSTRAINT `users_details_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
