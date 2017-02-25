<?php // модель таблицы категорий

function getAllMainCatsWithChildren($link) {
	$query = 'SELECT *
				FROM categories
				WHERE parent_id = 0';

	$result = mysqli_query($link, $query);
           
    if (!$result)
        die(mysqli_error($link));
    
    $n_rows = mysqli_num_rows($result);

    for ($i=0; $i < $n_rows; $i++)
    {
        $row = mysqli_fetch_assoc($result);    
        $categoriesTwig[] = $row;
        
    } return $categoriesTwig;
}