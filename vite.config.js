import create_config from "@kucrut/vite-for-wp";
import vue from "@vitejs/plugin-vue";
import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import { ElementPlusResolver } from "unplugin-vue-components/resolvers";
import { resolve } from "path";

export default create_config("admin/app/src/main.js", "admin/app/dist", {
	plugins: [
		vue(),
		AutoImport({
			resolvers: [ElementPlusResolver()],
		}),
		Components({
			resolvers: [ElementPlusResolver()],
		}),
	],
	publicDir: false,
	resolve: {
		alias: {
			"@": resolve(__dirname, "./admin/app/src"),
			"@components": resolve(__dirname, "./admin/app/src/components"),
			"@stores": resolve(__dirname, "./admin/app/src/stores"),
			"@assets": resolve(__dirname, "./admin/app/src/assets"),
			"@layouts": resolve(__dirname, "./admin/app/src/layouts"),
			"@views": resolve(__dirname, "./admin/app/src/views"),
			"@utilities": resolve(__dirname, "./admin/app/src/utilities"),
			"@helpers": resolve(__dirname, "./admin/app/src/helpers"),
			"@types": resolve(__dirname, "./admin/app/src/types"),
		},
	},
	build: {
		sourcemap: false, // Disable sourcemap in build.
	}
});
