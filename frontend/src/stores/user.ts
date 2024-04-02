import {computed, ref} from 'vue';
import {defineStore} from 'pinia';
import userProfileService from '../services/userProfileService'

interface User {
	id: number,
	name: string
}

export const useUserStore = defineStore('user', () => {
	const user = ref(getDefaultUser());
	const userLoading = ref(false);

	function setUser(userData: User) {
		user.value = userData;
		window.localStorage.setItem('user', JSON.stringify(userData))
		window.localStorage.setItem('csrf_token', JSON.stringify(userData))
	}

	function getDefaultUser(): User
	{
		return {
			id: 0,
      name: 'Anonymous',
		}
	}

	function logout() {
		user.value = getDefaultUser();
		window.localStorage.removeItem('user');
		window.localStorage.removeItem('token');
		window.localStorage.removeItem('csrf_token');
	}

	const isAuth = computed(() => {
		return user.value.id !== 0;
	});

	const name = computed(() => {
		if (user.value.hasOwnProperty('name')) {
			return user.value.name;
		}
		return 'Anonymous';
	});

	function loadUserProfile(): void {
		userLoading.value = true;
		userProfileService.loadUserProfile((profile: {}) => {
			user.value = getDefaultUser();
			userLoading.value = false;
		}, () => {
			userLoading.value = false;
		})
	}

	if (localStorage.getItem('token')) {
		loadUserProfile();
	}

	return {
		user,
		setUser,
		logout,
		isAuth,
		name,
	};
});
