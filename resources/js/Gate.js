export default class Gate {

  constructor(user) {
    this.user = user;
  }

  isAdmin() {
    return this.user.type === 'admin';
  }

  isUser() {
    return this.user.type === 'user';
  }

  isAdminOrUser() {
    if(this.user) {
      if (this.user.type === 'user' || this.user.type === 'admin') {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }
}

