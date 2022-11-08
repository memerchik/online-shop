DROP DATABASE eshopzab;
CREATE DATABASE eshopzab;
USE eshopzab;

CREATE TABLE `Customers`(
    `UserID` INT AUTO_INCREMENT PRIMARY KEY,
    `Username` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `Name` VARCHAR(255) NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `Status` VARCHAR(2) NOT NULL,
    `RegisterDate` DATE NOT NULL,
    `BirthDate` DATE NULL,
    `Surname` VARCHAR(255) NULL,
    `ProfilePicName` VARCHAR(255) NULL,
    `ShoppingCartContent` TEXT NULL
);
ALTER TABLE
    `Customers` ADD UNIQUE `customers_email_unique`(`Username`);
CREATE TABLE `Permissions`(
    `PermissionID` VARCHAR(2) NOT NULL PRIMARY KEY,
    `PermissionName` VARCHAR(50) NOT NULL,
    `ManageAdmins` BOOLEAN NOT NULL,
    `ManageProducts` BOOLEAN NOT NULL
);
CREATE TABLE `Orders`(
    `OrderID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `UserID` INT NOT NULL,
    `OrderDate` DATETIME NOT NULL,
    `OrderStatus` VARCHAR(255) NOT NULL
);
CREATE TABLE `Products`(
    `ProductID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ProductTitle` VARCHAR(255) NOT NULL,
    `Price` INT NOT NULL,
    `OldPrice` INT NOT NULL,
    `IsOnDiscount` BOOLEAN NOT NULL,
    `dateAdded` DATE NOT NULL,
    `userAdded` INT NOT NULL
);
CREATE TABLE `Description`(
    `DescriptionID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ProductID` INT NOT NULL,
    `Language` VARCHAR(255) NOT NULL,
    `Description` TEXT NOT NULL
);
CREATE TABLE `OrdersItemsLIst`(
    `WriteID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `OrderID` INT NOT NULL,
    `ItemID` INT NOT NULL,
    `ItemQuantity` INT NOT NULL
);
CREATE TABLE `Sales`(
    `ProductID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `StartDate` INT NOT NULL,
    `EndDate` INT NOT NULL,
    `OldPrice` INT NOT NULL,
    `SalePrice` INT NOT NULL,
    `AfterPrice` INT NULL,
    `userAdded` INT NOT NULL
);
CREATE TABLE `Pictures`(
    `ProductID` INT NOT NULL PRIMARY KEY,
    `Picture1` VARCHAR(255) NOT NULL,
    `Picture2` VARCHAR(255) NULL,
    `Picture3` VARCHAR(255) NULL,
    `Picture4` VARCHAR(255) NULL,
    `Picture5` VARCHAR(255) NULL
);
CREATE TABLE `Reviews`(
    `ReviewID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ProductID` INT NOT NULL,
    `ReviewAuthorName` VARCHAR(255) NOT NULL,
    `ReviewRating` INT NOT NULL,
    `ReviewDate` DATE NOT NULL,
    `ReviewText` TEXT NOT NULL
);
ALTER TABLE
    `Orders` ADD CONSTRAINT `orders_userid_foreign` FOREIGN KEY(`UserID`) REFERENCES `Customers`(`UserID`);
ALTER TABLE
    `Customers` ADD CONSTRAINT `customers_status_foreign` FOREIGN KEY(`Status`) REFERENCES `Permissions`(`PermissionID`);
ALTER TABLE
    `OrdersItemsLIst` ADD CONSTRAINT `ordersitemslist_orderid_foreign` FOREIGN KEY(`OrderID`) REFERENCES `Orders`(`OrderID`);
ALTER TABLE
    `OrdersItemsLIst` ADD CONSTRAINT `ordersitemslist_itemid_foreign` FOREIGN KEY(`ItemID`) REFERENCES `Products`(`ProductID`);
ALTER TABLE
    `Description` ADD CONSTRAINT `description_productid_foreign` FOREIGN KEY(`ProductID`) REFERENCES `Products`(`ProductID`);
ALTER TABLE
    `Pictures` ADD CONSTRAINT `pictures_productid_foreign` FOREIGN KEY(`ProductID`) REFERENCES `Products`(`ProductID`);
ALTER TABLE
    `Reviews` ADD CONSTRAINT `reviews_productid_foreign` FOREIGN KEY(`ProductID`) REFERENCES `Products`(`ProductID`);
ALTER TABLE
    `Products` ADD CONSTRAINT `products_useradded_foreign` FOREIGN KEY(`userAdded`) REFERENCES `Customers`(`UserID`);
ALTER TABLE
    `Sales` ADD CONSTRAINT `sales_useradded_foreign` FOREIGN KEY(`userAdded`) REFERENCES `Customers`(`UserID`);