<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php
      echo $config['project']['name'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
      body {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-color: #f8f9fa;
      }

      .content-wrapper {
          background-color: #ffffff;
          border: 1px solid #dee2e6;
          border-radius: 0.25rem;
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
          padding: 2rem;
          width: 100%;
          max-width: 600px;
      }
  </style>
</head>
<body style="background-color: #1f0f2f">
  <div class="content-wrapper">