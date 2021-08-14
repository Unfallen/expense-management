export default [
  {path: '/dashboard', component: require('./components/Dashboard.vue').default},
  {path: '/profile', component: require('./components/Profile.vue').default},
  {path: '/users', component: require('./components/Users.vue').default},
  {path: '/expenses', component: require('./components/expense/Expenses.vue').default},
  {path: '/categories', component: require('./components/Categories.vue').default},
  {path: '/', component: require('./components/Dashboard.vue').default},
  {path: '*', component: require('./components/NotFound.vue').default}
];
