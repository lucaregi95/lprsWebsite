<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Post.php';
require_once __DIR__ . '/../../src/repository/PostRepository.php';

$postRepository = new PostRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_post'])) {
    $post = $postRepository->getPost($_POST['id_post']);
    if ($post) {
        $postRepository->supprimerPost($_POST['id_post']);
    }
}

header('Location: tabPost.php');
exit;