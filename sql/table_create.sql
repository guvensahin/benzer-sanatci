START TRANSACTION;

CREATE TABLE `last_viewed` (
  `name` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `last_viewed`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);


COMMIT;