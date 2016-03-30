<?php
class VideoDAO implements DefaultDAO
{
  private function __construct() {
    if (!isset($_SESSION["videos"])) {
      $_SESSION["videos"] = [];
    }
  }


  public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
  }


  public function insert($object) {
    $novoVideo = new Video($object);
    $novoVideo->id = count($_SESSION["videos"]);
    $_SESSION["videos"][] = $novoVideo;

    return $novoVideo;
  }


  public function delete($object) {
    if ($_SESSION["videos"][$object->id]) {
      unset($_SESSION["videos"][$object->id]);
      return true;
    }

    return false;
  }


  public function deleteAll() {
    $_SESSION["videos"] = [];
  }


  public function update($object) {
    $video = $_SESSION["videos"][$object->id];

    if ($video) {
      $video->cursoId = $object->cursoId ? $object->cursoId : $video->cursoId;
      $video->titulo = $object->titulo ? $object->titulo : $video->titulo;
      $video->urlVideo = $object->urlVideo ? $object->urlVideo : $video->urlVideo;
      $video->urlImagem = $object->urlImagem ? $object->urlImagem : $video->urlImagem;
      $video->resumo = $object->resumo ? $object->resumo : $video->resumo;
      $video->disciplina = $object->disciplina ? $object->disciplina : $video->disciplina;

      return true;
    }

    return false;
  }


  public function getById($id) {
    return $_SESSION["videos"][$id];
  }


  public function getBy($data) {
    return array_filter($_SESSION["videos"], function($var) {
      return ($var->id == $data['id'] || $data['id'] === NULL) &&
              ($var->cursoId == $data['cursoId'] || $data['cursoId'] === NULL) &&
              ($var->titulo == $data['titulo'] || $data['titulo'] === NULL) &&
              ($var->urlVideo == $data['urlVideo'] || $data['urlVideo'] === NULL) &&
              ($var->urlImagem == $data['urlImagem'] || $data['urlImagem'] === NULL) &&
              ($var->resumo == $data['resumo'] || $data['resumo'] === NULL) &&
              ($var->disciplina == $data['disciplina'] || $data['disciplina'] === NULL);
    });
  }

  public function getAll() {
    return $_SESSION["videos"];
  }
}
