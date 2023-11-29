CREATE TABLE `fitness_plan_workouts` (
  `type` varchar(20) NOT NULL,
  `fitness_plan_level` varchar(10) NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `workout_name` varchar(50) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL
);

INSERT INTO `fitness_plan_workouts` (`type`, `fitness_plan_level`, `day_of_week`, `workout_name`, `sets`, `reps`)
VALUES
('Lose Weight', 'Beginner', 'Monday', 'Brisk Walk', 1, 30),
('Lose Weight', 'Beginner', 'Tuesday', 'Cycling', 1, 30),
('Lose Weight', 'Beginner', 'Wednesday', 'Swimming', 1, 30),
('Lose Weight', 'Beginner', 'Thursday', 'Brisk Walk', 1, 30),
('Lose Weight', 'Beginner', 'Friday', 'Cycling', 1, 30),
('Lose Weight', 'Beginner', 'Saturday', 'Swimming', 1, 30),
('Lose Weight', 'Beginner', 'Sunday', 'Rest', 0, 0),
('Flexibility', 'Beginner', 'Monday', 'Stretching', 2, 30),
('Flexibility', 'Beginner', 'Tuesday', 'Yoga', 1, 30),
('Flexibility', 'Beginner', 'Wednesday', 'Pilates', 1, 20),
('Flexibility', 'Beginner', 'Thursday', 'Stretching', 2, 30),
('Flexibility', 'Beginner', 'Friday', 'Yoga', 1, 30),
('Flexibility', 'Beginner', 'Saturday', 'Pilates', 1, 20),
('Flexibility', 'Beginner', 'Sunday', 'Rest', 0, 0),
('Get Toned', 'Beginner', 'Monday', 'Push-ups', 3, 10),
('Get Toned', 'Beginner', 'Tuesday', 'Dumbbell Curls', 3, 10),
('Get Toned', 'Beginner', 'Wednesday', 'Bodyweight Squats', 3, 10),
('Get Toned', 'Beginner', 'Thursday', 'Plank', 3, 30),
('Get Toned', 'Beginner', 'Friday', 'Jumping Jacks', 3, 20),
('Get Toned', 'Beginner', 'Saturday', 'Lunges', 3, 10),
('Get Toned', 'Beginner', 'Sunday', 'Rest', 0, 0);