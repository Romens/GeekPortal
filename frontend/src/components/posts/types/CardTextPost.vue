<template>
    <div class="card">
        <div class="card-body">
            <h3>{{post.title}}</h3>
            <p>{{post.text}}</p>
        </div>
				<div class="list-group list-group-flush">
					<div class="list-group-item">
						<div v-for="tag in post.tags">
							<span type="button" class="badge rounded-pill text-bg-primary">{{tag.name}}</span>
						</div>
					</div>
				</div>
        <div class="card-body py-0">
            <span>{{ $t('posted_by_author')}}</span>
						<b>{{post.author.name}}</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col text-left">
                    <ReactionButtons
                        :post="post"
                        :indexKey="indexKey">
                    </ReactionButtons>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="module" setup lang="ts">
    import ReactionButtons from "@/components/posts/ReactionButtons.vue";
		import moment from "moment";

    const {post, indexKey} = defineProps(['post', 'indexKey']);

		const createdAtHuman = moment(post.created_at).fromNow()

</script>

<style scoped>

</style>
