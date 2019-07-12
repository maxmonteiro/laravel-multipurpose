export default class Gate {
    constructor(user) {
        this.user = user;
    };

    isSuperAdmin() {
        return this.user.type === 'superadmin';
    };

    isAdmin() {
        return this.user.type === 'admin';
    };

    isUser() {
        return this.user.type === 'user';
    };

    isOrganization() {
        return this.user.type === 'organization';
    };

    isAdminOrSuperAdmin() {
        if(this.user.type === 'admin' || this.user.type === 'superadmin') {
            return true;
        }
    };
}
