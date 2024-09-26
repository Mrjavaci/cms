<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Surname</th>
      <th scope="col">E-mail</th>
      <th scope="col">Phone</th>
    </tr>

      <?php
      foreach ($users as $user): ?>
        <tr>
          <td><?php
              echo $user['id']; ?></td>
          <td><?php
              echo $user['name']; ?></td>
          <td><?php
              echo $user['surname']; ?></td>
          <td><?php
              echo $user['email']; ?></td>
          <td><?php
              echo $user['phone']; ?></td>
        </tr>
      <?php
      endforeach; ?>

  </thead>
</table>