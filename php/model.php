<?php

function dbConnect( $dsn, $user, $password ) {
    return new PDO( $dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );
}

function getCategories( $db ) {
    $sql = 'SELECT category_name FROM categories;';
    $stmnt = $db->prepare( $sql );
    
//    $stmnt->bindParam( ':fieldName', $fieldName );
//    $bind1 =  $stmnt->bindValue( ':fieldName', $fieldName );
//    var_dump( $bind1 );
//    $stmnt->bindParam( ':tableName', $tableName );
//    $bind2 = $stmnt->bindValue( ':tableName', $tableName );
//    var_dump($bind2);
//    $stmnt->execute();
    $stmnt->execute();
//    var_dump($exec);
    
//    var_dump( $stmnt->errorInfo() );

    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 0 );
//    $res = $stmnt->fetchAll();
//    print_r($res);
    return $res;
}
function getSubCategories( $db, $category) {

    $sql = 'SELECT categories.category_name,'
            . ' subcategories.subcategory_name'
            . ' FROM subcategories'
            . ' INNER JOIN categories'
            . ' ON subcategories.category_ID = categories.category_ID'
            . ' WHERE categories.category_name = "'
            . $category . '"';
//    $sql = 'SELECT brand.categories.category_name,'
//            . ' brand.subcategories.subcategory_name'
//            . ' FROM brand.subcategories'
//            . ' INNER JOIN brand.categories'
//            . ' ON brand.subcategories.category_ID = brand.categories.category_ID'
//            . ' WHERE brand.categories.category_name = "'
//            . $category . '"';
//    var_dump($sql);
    $stmnt = $db->prepare( $sql );
    
//    $stmnt->bindParam( ':fieldName', $fieldName );
//    $bind1 =  $stmnt->bindValue( ':fieldName', $fieldName );
//    var_dump( $bind1 );
//    $stmnt->bindParam( ':tableName', $tableName );
//    $bind2 = $stmnt->bindValue( ':tableName', $tableName );
//    var_dump($bind2);
//    $stmnt->execute();
    $stmnt->execute();
//    var_dump($exec);
    
//    var_dump( $stmnt->errorInfo() );

    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
//    print_r($res);
    return $res;
}

function getProduct( $db, $productID ) {

    $sql = 'SELECT brands.brand_name,'
            . ' products.product_name,'
            . ' products.product_price,'
            . ' products.product_descript,'
            . ' products.color,'
            . ' products.size,'
            . ' product_images.images_path,'
            . ' categories.category_name2,'
            . ' material.material_name,'
            . ' designers.designer_name'
            . ' FROM products'
            . ' INNER JOIN product_images'
            . ' ON products.product_ID = product_images.product_ID'
            . ' INNER JOIN brands'
            . ' ON products.brand_ID = brands.brand_ID'
            . ' INNER JOIN subcategories'
            . ' ON products.subcategory_ID = subcategories.subcategory_ID'
            . ' INNER JOIN categories'
            . ' ON subcategories.category_ID = categories.category_ID'
            . ' LEFT JOIN material'
            . ' ON products.material_ID = material.material_ID'
            . ' LEFT JOIN designers'
            . ' ON products.designer_ID = designers.designer_ID'
            . ' WHERE products.product_ID = "'
            . $productID . '"';

    $stmnt = $db->prepare( $sql );
    
    $stmnt->execute();
    
//    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
    $res = $stmnt->fetch( PDO::FETCH_ASSOC );
//    print_r($res);
    return $res;
}

function getProducts( $db ) {

    $sql = 'SELECT products.product_ID,'
            . ' brands.brand_name,'
            . ' products.product_name,'
            . ' products.product_price,'
            . ' product_images.images_path'
            . ' FROM products'
            . ' INNER JOIN product_images'
            . ' ON products.product_ID = product_images.product_ID'
            . ' INNER JOIN brands'
            . ' ON products.brand_ID = brands.brand_ID';


//    var_dump($sql);
    $stmnt = $db->prepare( $sql );
    
    $stmnt->execute();
//    var_dump($exec);
    
//    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
    $res = $stmnt->fetchAll( PDO::FETCH_ASSOC );
//    print_r($res);
    return $res;
}

function getIDs( $db ) {
    $sql = 'SELECT brand.products.product_ID FROM brand.products ORDER BY product_ID ASC;';

//    var_dump($sql);
    $stmnt = $db->prepare( $sql );
    
    $stmnt->execute();
//    var_dump($exec);
    
    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 0 );
//    $res = $stmnt->fetchAll();
//    $res = $stmnt->fetchAll( PDO::FETCH_ASSOC );
//    print_r($res);
    return $res;
}

function getUser( $db, $email ) {
    
//    $hash = hash($password);

    $sql = 'SELECT user_id,'
            . ' nickname,'
            . ' email,'
            . ' hash,'
            . ' phonenumber'
            . ' FROM users'
            . ' WHERE email = "'
            . $email . '"';
//    var_dump($sql);
    $stmnt = $db->prepare( $sql );
    
    $stmnt->execute();
    
//    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
    $res = $stmnt->fetch( PDO::FETCH_ASSOC );
//    var_dump($res);
//    print_r($res);
    return $res;
}
function getHash( $db, $user ) {
    
//    $query = sprintf( "SELECT hash FROM users WHERE user='%s';",
//                    pg_escape_string( $user[ nickname ] ) );
//                $row = pg_fetch_assoc( pg_query( $db, $query ) );

    $sql = "SELECT hash FROM users WHERE nickname = ?;";
//    var_dump($sql);
    $stmnt = $db->prepare( $sql );
    $stmnt->bindParam( 1, $user, PDO::PARAM_STR, 45);
    $stmnt->execute();
    
//    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
    $res = $stmnt->fetch( PDO::FETCH_ASSOC );
//    var_dump($res);
//    print_r($res);
    return $res;
}

function saveUser( $db, $user, $email, $password ) {

    $sql = "INSERT INTO users( nickname, email, hash ) VALUES( ?, ?, ? );";
    $stmnt = $db->prepare( $sql );
    $stmnt->bindParam( 1, $user, PDO::PARAM_STR, 45);
    $stmnt->bindParam( 2, $email, PDO::PARAM_STR, 45);
    $stmnt->bindParam( 3, password_hash( $password, PASSWORD_DEFAULT ) );
//    $res = $stmnt->fetchAll( PDO::FETCH_COLUMN, 1 );
//    $res = $stmnt->fetchAll();
//    $res = $stmnt->fetch( PDO::FETCH_ASSOC );
//    var_dump($res);
//    print_r($res);
    return $stmnt->execute();
}