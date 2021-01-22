CREATE TABLE User (
    userID INTEGER PRIMARY KEY,
    username VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    contact VARCHAR NOT NULL,
    name VARCHAR NOT NULL,
    photoURL VARCHAR NOT NULL,
    shelter BOOLEAN NOT NULL CHECK (shelter = 0 OR shelter = 1), -- if it is a shelter or not
    shelterUser VARCHAR REFERENCES User ON DELETE CASCADE --reference to the user of the shelter it belongs to
);
 
CREATE TABLE Pet (
    petID INTEGER PRIMARY KEY,
    species VARCHAR NOT NULL CHECK (species == 'dog' OR species == 'cat' OR species == 'pig' or species == 'other animals'),   
    name VARCHAR,
    age VARCHAR,
    location VARCHAR NOT NULL,
    state INTEGER NOT NULL CHECK (state = 0 OR state = 1), -- 0 not adopted, 1 adopted
    sex INTEGER CHECK (sex = 0 OR sex = 1),
    rescuer INTEGER NOT NULL REFERENCES User ON DELETE CASCADE,
    size INTEGER CHECK (size = 0 OR size = 1 OR size = 2),
    aboutmeText VARCHAR NOT NULL
);
 
CREATE TABLE Photo (
    photoID INTEGER PRIMARY KEY,
    url VARCHAR NOT NULL,
    altText VARCHAR,
    petID INTEGER NOT NULL REFERENCES Pet ON DELETE CASCADE
);
 
CREATE TABLE Question (
    questionID INTEGER PRIMARY KEY,
    questionText VARCHAR NOT NULL, 
    date DATETIME NOT NULL, -- date of the question 
    petID INTEGER NOT NULL REFERENCES Pet ON DELETE CASCADE, -- pet the question was about
    userID INTEGER NOT NULL REFERENCES User ON DELETE CASCADE--who asked the question
);
 
CREATE TABLE Answer (
    answerID INTEGER PRIMARY KEY, 
    answerText VARCHAR NOT NULL,
    date DATETIME NOT NULL, -- date of the answer
    questionID INTEGER NOT NULL REFERENCES Question ON DELETE CASCADE, -- question related to the answer
    userID INTEGER NOT NULL REFERENCES User ON DELETE CASCADE-- who answered the question
);
 
CREATE TABLE Favourite (
    favoritePetID INTEGER PRIMARY KEY,
    petID INTEGER NOT NULL REFERENCES Pet ON DELETE CASCADE, --pet favorited
    userID INTEGER NOT NULL REFERENCES User ON DELETE CASCADE  -- user who favorited pet
);
 
CREATE TABLE Proposal (
    proposalID INTEGER PRIMARY KEY,
    petID INTEGER NOT NULL REFERENCES Pet ON DELETE CASCADE, -- pet in the proposal
    userID INTEGER NOT NULL REFERENCES User ON DELETE CASCADE, --who proposed
    date DATETIME NOT NULL, -- when proposal was made
    text VARCHAR NOT NULL, 
    confirmed INTEGER NOT NULL CHECK (confirmed = 0 OR confirmed = 1 OR confirmed = 2 OR confirmed = 3) -- 0 accepted, 1 waiting for response, 2 rejected, 3 permanently rejected
);

CREATE TABLE Post (
    postID INTEGER PRIMARY KEY,
    userID INTEGER NOT NULL REFERENCES User ON DELETE CASCADE,
    text VARCHAR NOT NULL,
    photoURL VARCHAR NOT NULL
);

Insert into User values(NULL,'MariaMariana','$2y$10$7X7FtczDraicgrep9EmLWOq1Eynl.EIWogrwObFZ4/14fV2az9cTG','919191911','Maria Mariana', "../uploads/user/defaultAvatar.png", 0, NULL); -- pass:1234
Insert into User values(NULL,'JohnDoe','$2y$10$LgzNnca5JZ5aKIinETHCe.zNPpBgXHKUdTqd3Vq.Ao88E6LRw.8tW','919696969','John Doe', "../uploads/user/defaultAvatar.png", 0, 4);
Insert into User values(NULL,'KanKan','$2y$10$CgMnd4zFAlNWyl4HkEAnDOc5pHwC4nrGF/F6LR7fqSWUYL0id41ym','929292929','Kan Kan', "../uploads/user/defaultAvatar.png", 0, NULL);
Insert into User values(NULL,'SafeHome','$2y$10$LXjgQchECqONJA.TWEjcxenzLzIV6V3FOsy4OkYqreZYLM1e07sdu','919696969','Safe Home', "../uploads/user/defaultAvatar.png", 1, NULL);
Insert into User values(NULL,'ArkansasAnimals','$2y$10$dY5OWVVPl9qERFxHbEPH9udJpMU2E8GTGp.JUxcyT7TcvXEU9G9Je','929292929','Arkansas animals', "../uploads/user/defaultAvatar.png", 1, NULL);
 
Insert into Pet values(NULL,'dog', 'Dexter, Beaggle','3 years','Porto',0,0,1,0, 'Hi there my name is Dexter!<br> Dexter xxx');
Insert into Pet values(NULL,'cat', 'Daisy, Chartreux','6 months','Braga',0,1,2,1, 'Hi there my name is Daisy!<br>Daisy xxx');
Insert into Pet values(NULL,'pig', 'Dynamo, Undefined','2 years','Lisboa',0,0,1,0, 'Hi there my name is Dynamo!<br> Dynamo xxx');
Insert into Pet values(NULL,'other animals', 'Bob, Cob','15 years','Sintra',0,0,1,1,'Hi there my name is Bob!<br> Bob xxx');
Insert into Pet values(NULL,'dog', 'Ziggy, Pug','1 year and 6 months','Matosinhos',1,0,3,0, 'Hi there my name is Ziggy!<br> Ziggy xxx');

Insert into Photo values(NULL, '../uploads/pet/1.jpg','Photo of Dexter', 1);
Insert into Photo values(NULL, '../uploads/pet/2.png','Photo of Daisy', 2);
Insert into Photo values(NULL, '../uploads/pet/3.jpg','Photo of Dynamo', 3);
Insert into Photo values(NULL, '../uploads/pet/4.jpeg','Photo of Bob', 4);
Insert into Photo values(NULL, '../uploads/pet/5.jpeg','Photo of Ziggy', 5);
 
Insert into Question values(NULL, 'Has he been vaccinated?', strftime('%Y-%m-%d','2020-11-27'), 1, 3);
Insert into Question values(NULL, 'Does she get scared easily?', strftime('%Y-%m-%d','2020-11-23'), 2, 1);
Insert into Question values(NULL, 'Does he make a lot of noise?', strftime('%Y-%m-%d','2020-11-24'), 3, 3);
Insert into Question values(NULL, 'Is he calm?', strftime('%Y-%m-%d','2020-11-25'), 4, 3);
Insert into Question values(NULL, 'Does he get well with children?', strftime('%Y-%m-%d','2020-11-26'), 5, 1);
 
Insert into Answer values(NULL, 'Yes, he is.', strftime('%Y-%m-%d','2020-11-27'), 1, 1);
Insert into Answer values(NULL, 'Not really, she is pretty calm.', strftime('%Y-%m-%d','2020-11-25'), 2, 2);
Insert into Answer values(NULL, 'No, just a normal pig.', strftime('%Y-%m-%d','2020-11-26'), 3, 1);
Insert into Answer values(NULL, 'Very well, children love him.', strftime('%Y-%m-%d','2020-11-26'), 4, 1);
 
Insert into Favourite values(NULL, 2, 1);
Insert into Favourite values(NULL, 1, 2);
Insert into Favourite values(NULL, 3, 3);

Insert into Proposal values(NULL, 1, 2, strftime('%Y-%m-%d','2020-11-27'), 'I have a young daughter that is passionate about dogs, I''m hopping Dexter can be her new mate', 1);
Insert into Proposal values(NULL, 4, 2, strftime('%Y-%m-%d','2020-11-26'), 'I''ve riding for all my life and have a horse facility that would be an awesome home for Bob', 1);
Insert into Proposal values(NULL, 1, 3, strftime('%Y-%m-%d','2020-11-25'), 'I need a new buddy to keep me company.', 1);

Insert into Post values(NULL, 2, 'Daisy is recovering well from living in the streets!', '../uploads/post/1.jpg');
Insert into Post values(NULL, 1, 'Here is Dexter showing off his skills!', '../uploads/post/2.jpg');
Insert into Post values(NULL, 3, 'Ziggy likes to sleep a lot... Here he is yawning!', '../uploads/post/3.jpg');
