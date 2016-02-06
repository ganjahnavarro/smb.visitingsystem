DELIMITER $$

DROP TRIGGER IF EXISTS `faqs_insert_trigger` $$
CREATE TRIGGER `faqs_insert_trigger` AFTER INSERT on `faqs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('An FAQ with question: ', NEW.question, ' has been created.'));
END$$

DROP TRIGGER IF EXISTS `faqs_update_trigger` $$
CREATE TRIGGER `faqs_update_trigger` AFTER UPDATE on `faqs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('An FAQ with question: ', NEW.question, ' has been updated.'));
END$$


DROP TRIGGER IF EXISTS `faqs_delete_trigger` $$
CREATE TRIGGER `faqs_delete_trigger` AFTER DELETE on `faqs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('An FAQ with question: ', OLD.question, ' has been deleted.'));
END$$

DELIMITER ;



DELIMITER $$

DROP TRIGGER IF EXISTS `users_insert_trigger` $$
CREATE TRIGGER `users_insert_trigger` AFTER INSERT on `users`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('User: ', NEW.username, ' (', NEW.fname, ' ', NEW.lname, ') has been created.'));
END$$

DROP TRIGGER IF EXISTS `users_update_trigger` $$
CREATE TRIGGER `users_update_trigger` AFTER UPDATE on `users`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('User: ', NEW.username, ' (', NEW.fname, ' ', NEW.lname, ') has been updated.'));
END$$


DROP TRIGGER IF EXISTS `users_delete_trigger` $$
CREATE TRIGGER `users_delete_trigger` AFTER DELETE on `users`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('User: ', OLD.username, ' (', OLD.fname, ' ', OLD.lname, ') has been deleted.'));
END$$

DELIMITER ;



DELIMITER $$

DROP TRIGGER IF EXISTS `walkinvisitors_insert_trigger` $$
CREATE TRIGGER `walkinvisitors_insert_trigger` AFTER INSERT on `walkinvisitors`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('A walk in visitor (', NEW.firstname, ' ', NEW.lastname, ') has entered our premises.'));
END$$

DROP TRIGGER IF EXISTS `walkinvisitors_delete_trigger` $$
CREATE TRIGGER `walkinvisitors_delete_trigger` AFTER DELETE on `walkinvisitors`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('A walk in visitor record (', OLD.firstname, ' ', OLD.lastname, ') has been deleted.'));
END$$

DELIMITER ;



DELIMITER $$

DROP TRIGGER IF EXISTS `walkthroughs_insert_trigger` $$
CREATE TRIGGER `walkthroughs_insert_trigger` AFTER INSERT on `walkthroughs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('Walkthrough (Title: ', NEW.name, ') has been created.'));
END$$

DROP TRIGGER IF EXISTS `walkthroughs_update_trigger` $$
CREATE TRIGGER `walkthroughs_update_trigger` AFTER UPDATE on `walkthroughs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('Walkthrough (Title: ', NEW.name, ') has been updated.'));
END$$

DROP TRIGGER IF EXISTS `walkthroughs_delete_trigger` $$
CREATE TRIGGER `walkthroughs_delete_trigger` AFTER DELETE on `walkthroughs`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('Walkthrough (Title: ', OLD.name, ') has been deleted.'));
END$$

DELIMITER ;



DELIMITER $$

DROP TRIGGER IF EXISTS `appointments_insert_trigger` $$
CREATE TRIGGER `appointments_insert_trigger` AFTER INSERT on `appointments`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat(
        (select concat(fname, ' ', lname) from users where id = NEW.userid),
        ' has requested an appointment on ', NEW.requesteddate, ' ', NEW.requestedtime));
END$$

DROP TRIGGER IF EXISTS `appointments_update_trigger` $$
CREATE TRIGGER `appointments_update_trigger` AFTER UPDATE on `appointments`
FOR EACH ROW
BEGIN
    IF (NEW.status = 'APPROVED') THEN
      INSERT INTO audittrail
        (message)
      VALUES
        (concat(
          (select concat(fname, ' ', lname) from users where id = NEW.userid),
          ' appointment on ', NEW.requesteddate, ' ', NEW.requestedtime, ' has been approved.'));
    END IF;

    IF (NEW.status = 'DISAPPROVED') THEN
      INSERT INTO audittrail
        (message)
      VALUES
        (concat(
          (select concat(fname, ' ', lname) from users where id = NEW.userid),
          ' appointment on ', NEW.requesteddate, ' ', NEW.requestedtime, ' has been disapproved.'));
    END IF;

    IF (NEW.status = 'RESCHEDULED') THEN
      INSERT INTO audittrail
        (message)
      VALUES
        (concat(
          (select concat(fname, ' ', lname) from users where id = NEW.userid),
          ' appointment on ', NEW.requesteddate, ' ', NEW.requestedtime, ' has been rescheduled on ', NEW.date, ' ', NEW.time));
    END IF;
END$$

DROP TRIGGER IF EXISTS `appointments_delete_trigger` $$
CREATE TRIGGER `appointments_delete_trigger` AFTER DELETE on `appointments`
FOR EACH ROW
BEGIN
    INSERT INTO audittrail
      (message)
    VALUES
      (concat('Appointment record by (', (select concat(fname, ' ', lname) from users where id = OLD.userid),
        ') requested on ', OLD.requesteddate, ' ', OLD.requestedtime, ' has been deleted.'));
END$$

DELIMITER ;



DELIMITER $$

DROP TRIGGER IF EXISTS `visitinfo_update_trigger` $$
CREATE TRIGGER `visitinfo_update_trigger` AFTER UPDATE on `visitinfo`
FOR EACH ROW
BEGIN
    IF (NEW.timein IS NOT NULL) THEN
      INSERT INTO audittrail
        (message)
      VALUES
        (concat(
          (select concat(fname, ' ', lname) from users where id = (select userid from appointments where visitinfoid = NEW.id)),
          ' has entered our premises.'));
    END IF;

    IF (NEW.timeout IS NOT NULL) THEN
      INSERT INTO audittrail
        (message)
      VALUES
        (concat(
          coalesce(
            (select concat(fname, ' ', lname) from users where id = (select userid from appointments where visitinfoid = NEW.id)),
            (select concat(firstname, ' ', lastname) from walkinvisitors where visitinfoid = NEW.id)),
          ' has timed out by ', NEW.timeout));
    END IF;
END$$

DELIMITER ;
