DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `square_root`(IN number DOUBLE, OUT result DOUBLE)
BEGIN
    DECLARE guess DOUBLE;
    DECLARE epilapse DOUBLE;
    
    SET guess = number / 2;
    SET epilapse = 0.00001;
    
    loop_label: LOOP
        SET guess = (guess + (number / guess)) / 2;
        
        IF ABS((guess * guess) - number) <= epilapse THEN
            LEAVE loop_label;
        END IF;
    END LOOP;
    
    SET result = guess;
END$$
DELIMITER ;