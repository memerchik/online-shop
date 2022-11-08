USE eshopzab;

INSERT INTO Permissions (`PermissionID`,`PermissionName`,`ManageAdmins`,`ManageProducts`) VALUES (0, 'Customer', FALSE, FALSE);
INSERT INTO Permissions (`PermissionID`,`PermissionName`,`ManageAdmins`,`ManageProducts`) VALUES (1, 'Manager', FALSE, TRUE);
INSERT INTO Permissions (`PermissionID`,`PermissionName`,`ManageAdmins`,`ManageProducts`) VALUES (2, 'Admin', TRUE, TRUE);


INSERT INTO Customers (`Username`,`Email`,`Name`,`Password`,`Status`, `RegisterDate`,`ProfilePicName`) VALUES ('admin', 'yaro3245@gmail.com', 'Yaroslav', '21232f297a57a5a743894a0e4a801fc3', 2, '2022-06-26','default.jpg');

INSERT INTO Products(`ProductTitle`,`Price`,`OldPrice`,`IsOnDiscount`,`dateAdded`,`userAdded`) VALUES ('BoomBox','100$','150$', FALSE, '2022-06-27', 1);
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (1, 'en', 'English description');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (1, 'ua', 'Ukraininan description');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (1, 'fr', 'French description');
INSERT INTO Pictures VALUES (1, '1-1.jpg','1-2.jpg','1-3.jpg','1-4.jpg','1-5.jpg');

INSERT INTO Products(`ProductTitle`,`Price`,`OldPrice`,`IsOnDiscount`,`dateAdded`,`userAdded`) VALUES ('Phone','150$','200$', FALSE, '2022-06-27', 1);
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (2, 'en', 'English description2');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (2, 'ua', 'Ukraininan description2');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (2, 'fr', 'French description2');
INSERT INTO Pictures(`ProductID`,`Picture1`,`Picture2`,`Picture3`,`Picture4`,`Picture5`) VALUES (2, '2-1.jpg','','','','');

INSERT INTO Products(`ProductTitle`,`Price`,`OldPrice`,`IsOnDiscount`,`dateAdded`,`userAdded`) VALUES ('IPhone','150$','200$', FALSE, '2022-06-27', 1);
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (3, 'en', 'English description3');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (3, 'ua', 'Ukraininan description3');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (3, 'fr', 'French description3');
INSERT INTO Pictures(`ProductID`,`Picture1`,`Picture2`,`Picture3`,`Picture4`,`Picture5`) VALUES (3, '3-1.jpg','','','','');

INSERT INTO Products(`ProductTitle`,`Price`,`OldPrice`,`IsOnDiscount`,`dateAdded`,`userAdded`) VALUES ('Samsung','150$','200$', FALSE, '2022-06-27', 1);
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (4, 'en', 'English description2');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (4, 'ua', 'Ukraininan description2');
INSERT INTO Description(`ProductID`,`Language`,`Description`) VALUES (4, 'fr', 'French description2');
INSERT INTO Pictures(`ProductID`,`Picture1`,`Picture2`,`Picture3`,`Picture4`,`Picture5`) VALUES (4, '4-1.jpg','','','','');