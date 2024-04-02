<template>
    <div class="reaction-buttons">
        <div class="btn-group btn-group-sm w-100" v-if="post.reactions">
            <button type="button"
                v-for="(result, reaction) in map"
                    :disabled="post.reactionloading"
                @click="result
                    ? unsetReaction(post.id, reaction + '')
                    : setReaction(post.id, reaction + '')"
                :class="['btn', (result ? 'btn-primary' : 'btn-outline-primary')]"
            >
                {{reaction}}
                {{post.reactions.statistics[reaction]}}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import {computed, ref, toRefs} from "vue";
import Api from "@/api";

const props = defineProps(['post'])
const post = ref(props.post)

const map = computed(() => {
    let map = {} as any[string];
		if (post.value.reactions) {
			for (let reaction in post.value.reactions.statistics) {
				map[reaction] = false;
			}
			for (let reaction in post.value.reactions.userReaction) {
				if (post.value.reactions.userReaction[reaction]) {
					map[reaction] = true;
				}
			}
		}

    return map;
});

function setReaction(postId: bigint, reaction: string )
{
	console.info(post, post.value);
	post.value.reactionloading = true;
	Api
		.post('api/posts/' + postId + '/setReaction', {'reaction': reaction,})
		.then(({data}) => {updateStatistics(data)})
		.catch(result => {console.error(result)})
}
function unsetReaction(postId: bigint, reaction: string )
{console.info(post, post.value);
	post.value.reactionloading = true;
	Api
		.post('/api/posts/' + postId + '/unsetReaction', {'reaction': reaction})
		.then(({data}) => {updateStatistics(data)})
		.catch(result => {console.error(result)})
}
function updateStatistics(data:any): void {
	let updatedData = post.value as any[any];
	updatedData.reactions = data.data.reactions;
	post.value = updatedData;
	updatedData.reactionloading = false;
}



</script>

<style scoped>
</style>
