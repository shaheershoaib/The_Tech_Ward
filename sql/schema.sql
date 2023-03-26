SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




CREATE TABLE `user` (
 
  
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `password` varchar(255) NOT NULL,
  `pfp` BLOB
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `discussion` (
 
  
  `discussionId` int AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` BLOB,
  `email` varchar(255) NOT NULL,
  FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `comment`(
`commentId` int AUTO_INCREMENT PRIMARY KEY,
`body` varchar(500) NOT NULL,
`likeCount` int NOT NULL,
`discussionId` int NOT NULL,
`email` varchar(255) NOT NULL,
FOREIGN KEY (discussionId) REFERENCES discussion(discussionId)  ON DELETE CASCADE,
FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
