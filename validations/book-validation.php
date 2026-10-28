<?php
function getBookRequest($request) {
   return [
        'title' => htmlspecialchars($request['title']),
        'isbn' => htmlspecialchars($request['isbn']),
        'year' => htmlspecialchars($request['year']),
        'stock' => htmlspecialchars($request['stock']),
        'category_id' => htmlspecialchars($request['category_id']),
        'description' => htmlspecialchars($request['description']),
        'author_ids' => $request['author_ids']
    ];
}

function validateBook($request, $ignoreBookId = 0){
    $errors = [];
    if($request['title'] == ''){
        $errors['title'] = "Judul Buku perlu diisi";
    }
    elseif(mb_strlen($request["title"]) > 100){
        $errors['title'] = "Judul Buku tidak boleh melebihi dari 100 karakter";
    }        
    if($request['isbn'] == ''){
        $errors['isbn'] = "ISBN wajib diisi";
    }
    elseif(isIsbnTaken($request["isbn"], $ignoreBookId)){
        $errors['isbn'] = "ISBN sudah terdaftar sebelumnya";
    }      
    if($request['year'] == ''){
        $errors['year'] = "Tahun terbit wajib diisi";
    } 
    elseif(!is_int(intval($request["year"]))){
        $errors['year'] = "Tahun terbit wajib diisi dengan angka";
    }
    if($request['stock'] == ''){
        $errors['stock'] = "Stok terbit wajib diisi";
    } 
    elseif(!is_int(intval($request["stock"]))){
        $errors['stock'] = "Stok terbit wajib diisi dengan angka";
    }
    if($request["category_id"] == ""){
        $errors["category_id"] = "Kategori wajib dipilih";
    }
    elseif(!isCategoryExists($request["category_id"])){
        $errors["category_id"] = "Kategori yang dipilih tidak valid";
    }
    if($request['description'] == ''){
        $errors['description'] = "Deskripsi Buku perlu diisi";
    }
    elseif(mb_strlen($request["description"]) > 200){
        $errors['description'] = "Deskripsi Buku tidak boleh melebihi dari 200 karakter";
    }
    if(count($request["author_ids"]) < 1){
        $errors["author_ids"] = "Penulis buku wajib dipilih";
        }
    else{
        $authors = getAuthors();
        $validAuthorIds = array_column($authors,"id");
        foreach($request['author_ids'] as $authorId){
            if(!in_array($authorId, $validAuthorIds)){
            $errors["author_ids"] = "Ada Penulis buku yang dipilih tidak valid";
            }
        }
    }
    return $errors;
}

?>
