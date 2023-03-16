<script setup>
import JumboBoxTitle from "@layouts/JumboBoxTitle.vue";
import OptionBox from "@components/options/OptionBox.vue";
const docLink = "https://docs.addonify.com/";
</script>
<template>
	<JumboBoxTitle title="General settings" :doc-link="docLink" />
	<OptionBox />
</template>
