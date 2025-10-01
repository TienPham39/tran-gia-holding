<template>
  <header
    class="navbar bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm"
  >
    <!-- Drawer toggle -->
    <nav class="flex-none lg:hidden">
      <label
        @click="$emit('toggle-drawer')"
        class="btn btn-square btn-ghost"
      >
        <Icon
          icon="line-md:close-to-menu-alt-transition"
          class="inline-block w-5 h-5"
        />
      </label>
    </nav>

    <!-- Search -->
    <section class="flex-1">
      <div class="form-control">
        <input
          type="text"
          placeholder="Search"
          class="input input-bordered w-48 ml-2 md:w-auto"
        />
      </div>
    </section>

    <!-- Actions -->
    <section class="flex gap-6">
      <!-- Avatar dropdown -->
      <div class="dropdown dropdown-end">
        <button
          tabindex="0"
          role="button"
          class="btn btn-ghost btn-circle avatar"
        >
          <div class="w-10 rounded-full">
            <img
              src="/images/Tommy-Shelby.jpg"
              alt="User"
            />
          </div>
        </button>
        <ul
          tabindex="0"
          class="mt-5 z-[1] p-2 shadow menu menu-sm dropdown-content bg-white rounded-box w-58 space-y-3 font-semibold text-base"
        >
          <li><a>Profile</a></li>
          <li><a>Settings</a></li>
          <li><a>Logout</a></li>
        </ul>
      </div>
    </section>
  </header>
</template>

<script setup>
defineEmits(["toggle-drawer"]);
</script>
