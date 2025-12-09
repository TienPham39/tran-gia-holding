<template>
  <button class="hover-effect font-mont uppercase cursor-pointer font-semibold text-white text-xl rounded-md flex items-center gap-2">
    <span></span>
    
    <slot></slot>

    <slot name="icon"></slot>

    <!-- Border bottom -->
    <div class="bottom-left"></div>
    <div class="bottom-right"></div>
  </button>
</template>

<script setup>
// Component không cần logic, chỉ đóng gói UI + hiệu ứng
</script>

<style scoped>
.hover-effect {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(1px);
  padding: 0.5rem 1.75rem;
}

.hover-effect span {
  position: absolute;
  inset: 0;
  pointer-events: none;
}

/* ==== Vertical Borders ==== */
.hover-effect span::before,
.hover-effect span::after {
  content: "";
  position: absolute;
  width: 3px;
  height: 0%;
  background: #ffffff;
  transition: height 0.8s ease-in-out;
}

.hover-effect span::before {
  left: 0;
  bottom: 0;
}

.hover-effect span::after {
  right: 0;
  top: 0;
}

/* ==== Horizontal borders ==== */
.hover-effect::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 4px;
  width: 51%;
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  height: 4px;
  width: 50%;
  background: linear-gradient(90deg, #4d080c, #ffffff);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect .bottom-left {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 4px;
  width: 51%;
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect .bottom-right {
  position: absolute;
  bottom: 0;
  right: 0;
  height: 4px;
  width: 50%;
  background: linear-gradient(270deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

/* Hover trigger */
.hover-effect:hover span::before,
.hover-effect:hover span::after {
  height: 100%;
}

.hover-effect:hover::before,
.hover-effect:hover::after,
.hover-effect:hover .bottom-left,
.hover-effect:hover .bottom-right {
  transform: scaleX(1);
}
</style>
