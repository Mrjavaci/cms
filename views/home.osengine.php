<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Uri</th>
      <th scope="col">Type</th>
      <th scope="col">Middlewares</th>
      <th scope="col">Method</th>
    </tr>

      <?php
      foreach ($routes as $route): ?>
        <tr>
          <td><?php
              echo $route['route']; ?></td>
          <td><?php
              echo $route['type']; ?></td>
          <td><?php
              echo json_encode($route['middlewares']); ?></td>
          <td><?php
              echo $route['method']; ?></td>
        </tr>
      <?php
      endforeach; ?>

  </thead>
</table>