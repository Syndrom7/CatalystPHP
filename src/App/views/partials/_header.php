<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catalyst PHP | <?php echo $title ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Code&family=M+PLUS+Rounded+1c&family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/main.css" />
</head>

<body class="font-['M PLUS Rounded 1c']">
  <!-- Start Header -->
  <header class="bg-indigo-900">
    <nav class="mx-auto flex container items-center justify-between py-4" aria-label="Global">
      <a href="/" class="-m-1.5 p-1.5 text-white text-2xl font-bold">Catalyst PHP</a>
      <!-- Nav Links -->
      <div class="flex lg:gap-x-10">
        <?php if(isset($_SESSION["user"])) : ?>
          <a href="/logout" class="text-gray-300 hover:text-white transition">Logout</a>
        <?php else : ?>
          <a href="/login" class="text-gray-300 hover:text-white transition">Login</a>
          <a href="/register" class="text-gray-300 hover:text-white transition">Register</a>
        <?php endif ?>
      </div>
    </nav>
  </header>
  <!-- End Header -->