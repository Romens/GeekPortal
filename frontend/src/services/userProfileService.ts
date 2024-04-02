import Api from "@/api";

const UserProfileService = {
    loadUserProfile: (callback: Function, fallback:any = null) => {
        Api
            .get('/api/profile')
            .then(response => {
                callback(response.data.data);
            })
            .catch(err => {
                // console.error('UserProfileService@loadUserProfile', err);
                if (typeof fallback === 'function') {
                    fallback(err)
                }
            })
        ;
    }
}

export default UserProfileService;
