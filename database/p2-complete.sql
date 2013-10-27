/*-------------------------------------------------------------------------------------------------
This will drop existing posts, users and users_users table if you have them.
-------------------------------------------------------------------------------------------------*/

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `posts` (`post_id`, `created`, `modified`, `user_id`, `content`) VALUES
(1, 1382587331, 1382587331, 1, 'Education is the silver bullet. Education is everything. We don''t need little changes, we need gigantic, monumental changes. Schools should be palaces. The competition for the best teachers should be fierce. They should be making six-figure salaries. Schools should be incredibly expensive for government and absolutely free of charge to its citizens, just like national defense. That''s my position. I just haven''t figured out how to do it yet. '),
(2, 1382587349, 1382587349, 1, 'Over the past half century, we''ve split the atom, we''ve spliced the gene and we''ve roamed Tranquility Base. We''ve reached for the stars and never have we been closer to having them in our grasp. New science, new technology is making the difference between life and death, and so we need a national commitment equal to this unparalleled moment of possibility. And so I announce to you tonight that I will bring the full resources of the Federal Government and the full reach of my office to this fundamental goal: We will cure cancer by the end of this decade. '),
(3, 1382587402, 1382587402, 2, 'Cause those large clocks on the wall that are run by the US Navy say your watch sucks. In fact they say your watch sucks in four different time zones.'),
(4, 1382587439, 1382587439, 2, 'Air Force One undergoes maintenance every day, whether the plane''s gonna be flying or not. Every 154 days, the plane''s completely taken apart and put back together again. 24 hours before wheels-up, fuel is sealed in a tank truck and guarded by sharpshooters. One hour before wheels-up, Air Force specialist drain off a gallon and analyze it for purity and the right levels of octane and water. The wiring - and this is gonna be an area - is shielded to protect it from a thermonuclear blast. If you want to sabotage it, you have to get by 48 armed members of the Air Lift Security Unit or join the maintenance crew, which takes 12 years after a two-year background check. \r\n'),
(5, 1382587511, 1382587511, 3, 'For 90 minutes that night, there was a coup dՎtat in this country.'),
(6, 1382587607, 1382587607, 1, 'No, honestly, I am dumb. Most of the time I''m playing smart.');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` int(11) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezone`, `first_name`, `last_name`, `email`) VALUES
(1, 1382587237, 0, '857524632803dbfb0f599588b9194953e42d6a32', '01cec651c12d15c5c57693e69ce0154b227f4701', 0, '', 'Sam', 'Seaborn', 'sam@whitehouse.gov'),
(2, 1382587246, 0, '7a442ed0553d9c432547f6b21006442ea723477f', '25050aaf8ffe20ba4ed26811caee19b0d2b402e3', 0, '', 'Donna', 'Moss', 'donna@whitehouse.gov'),
(3, 1382587258, 0, '67f6ec36e6d01aa360aca643f8c33cf190ba9a9c', '5c08403a5a6a563561db546c67c6c41ea28ef830', 0, '', 'Toby', 'Ziegler', 'toby@whitehouse.gov'),
(4, 1382587269, 0, '88661e8fd533ba3494a3880e5d3b16c50c851ddb', '1c8479faf41c5b2b6a92bb9a6ea17164d5669142', 0, '', 'CJ', 'Cregg', 'cj@whitehouse.gov');

DROP TABLE IF EXISTS `users_users`;
CREATE TABLE `users_users` (
  `user_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'follower',
  `user_id_followed` int(11) NOT NULL COMMENT 'followed',
  PRIMARY KEY (`user_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `users_users` (`user_user_id`, `created`, `user_id`, `user_id_followed`) VALUES
(1, 1382587640, 1, 2),
(2, 1382587662, 2, 1),
(3, 1382587663, 2, 2),
(4, 1382587664, 2, 3),
(5, 1382587664, 2, 4),
(6, 1382587709, 3, 1);


ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
