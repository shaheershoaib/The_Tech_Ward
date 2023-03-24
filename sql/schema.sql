SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




CREATE TABLE `user` (
 
  
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `discussion` (
 
  
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` BLOB,
  `email` varchar(255) NOT NULL,
  FOREIGN KEY (email) REFERENCES user(email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

