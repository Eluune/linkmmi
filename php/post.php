<div class="new-message">
  <h2>Nouveau Post</h2>
  <form action="php/topic.php" method="post" enctype="multipart/form-data">
    <textarea name="contenuTopic" placeholder="Message"></textarea>
    <input type="text" name="tagsTopic" placeholder="Tags séparés par des espaces">

    <input type="file" name="imgTopic" id="file" class="inputfile" />
    <label for="file"><i class="icofont-image"></i></label>

    <button type="submit" name="create">Envoyer</button>
  </form>
</div>
