SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- CREATE DATABASE project;
-- USE project;



CREATE TABLE `user` (
 
  
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) PRIMARY KEY,
  `password` varchar(255) NOT NULL,
  `pfp` BLOB,
  `contentType` varchar(255),
    `disabled` INT NOT NULL DEFAULT 0,
  `admin` boolean
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `discussion` (
 `discussionId` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` BLOB,
  `contentType` varchar(255),
  FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `comment`(
`commentId` int AUTO_INCREMENT PRIMARY KEY,
`body` varchar(500) NOT NULL,
`discussionId` int NOT NULL,
`email` varchar(255) NOT NULL,
FOREIGN KEY (discussionId) REFERENCES discussion(discussionId)  ON DELETE CASCADE,
FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE discussionRating(
    `discussionId` int,
    `email` varchar(255) NOT NULL,
    `isLike` int NOT NULL, /* isLike = 1 if its a like, else 0 */
    FOREIGN KEY (discussionId) REFERENCES discussion(discussionId)  ON DELETE CASCADE,
    FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE,
    PRIMARY KEY (discussionId, email)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE commentRating(

    `commentId` int,
    `email` varchar(255),
    `isLike` int NOT NULL, /* isLike = 1 if its a like, else 0 */
    FOREIGN KEY (commentId) REFERENCES comment(commentId)  ON DELETE CASCADE,
    FOREIGN KEY (email) REFERENCES user(email)  ON DELETE CASCADE,
    PRIMARY KEY(commentId, email)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;





