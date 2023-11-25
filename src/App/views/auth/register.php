<?php include $this->resolve("partials/_header.php"); ?>


<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
  <div class="mx-auto max-w-lg">
    <form method="POST" class="mb-0 mt-6 space-y-4 rounded-lg p-4 shadow-lg sm:p-6 lg:p-8">
    <?php echo $this->csrf($csrfToken); ?>
    <p class="text-center text-lg font-medium">Register your account</p>

      <div>
        <label for="email" class="sr-only">Email</label>
        <div class="relative">
          <input type="email" name="email" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm" placeholder="Enter email"
            value="<?php echo htmlspecialchars($this->oldInput($oldFormData, 'email')); ?>"
          />
        </div>
      </div>

      <?php foreach ($this->getErrorMessages('email', $errors) as $error) : ?>
        <div class="bg-gray-100 mt-2 p-4 text-red-500 rounded-lg">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endforeach; ?>

      <div>
        <label for="password" class="sr-only">Password</label>
        <div class="relative">
          <input type="password" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm" placeholder="Enter password" name="password"/>
        </div>
      </div>

      <?php foreach ($this->getErrorMessages('password', $errors) as $error) : ?>
        <div class="bg-gray-100 mt-2 p-4 text-red-500 rounded-lg">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endforeach; ?>

      <div>
        <label for="confirmPassword" class="sr-only">Confirm Password</label>
        <div class="relative">
          <input type="password" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm" placeholder="Enter password" name="confirmPassword"/>
        </div>
      </div>

      <?php foreach ($this->getErrorMessages('confirmPassword', $errors) as $error) : ?>
        <div class="bg-gray-100 mt-2 p-4 text-red-500 rounded-lg">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endforeach; ?>
      
      <button type="submit" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">
        Sign up
      </button>

      <p class="text-center text-sm text-gray-500">
        Have an account?
        <a class="underline" href="/register">Sign in</a>
      </p>
    </form>
  </div>
</div>

<?php include $this->resolve("partials/_footer.php"); ?>

