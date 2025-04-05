# Hamburger Menu (Global)

## HTML Structure
In `header.php`:

```php
<header>
  <button class="hamburger" aria-label="Toggle Menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
  <nav class="menu">
    <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
  </nav>
</header>
```

## CSS
Add to `style.css`:

```css
.hamburger {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1000;
  background: none;
  border: none;
  cursor: pointer;
}

.hamburger span {
  display: block;
  width: 30px;
  height: 3px;
  background-color: #3E2723;
  margin: 5px 0;
  transition: all 0.3s;
}

.menu {
  position: fixed;
  top: 0;
  right: -100%;
  width: 250px;
  height: 100vh;
  background-color: #F5F5DC;
  padding: 60px 20px 20px;
  transition: right 0.5s;
}

.menu.open {
  right: 0;
}

.menu ul {
  list-style: none;
}

.menu a {
  color: #3E2723;
  text-decoration: none;
  font-size: 1.2em;
}

.menu a:hover {
  color: #A52A2A;
}
```

## JavaScript
Add to `scripts.js`:

```javascript
const hamburger = document.querySelector('.hamburger');
const menu = document.querySelector('.menu');

hamburger.addEventListener('click', () => {
  menu.classList.toggle('open');
  gsap.to(menu, {
    right: menu.classList.contains('open') ? 0 : '-100%',
    duration: 0.5,
    ease: 'power2.inOut',
  });
});
``` 