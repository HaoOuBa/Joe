import { nodeResolve } from '@rollup/plugin-node-resolve';
import uglify from '@lopatnov/rollup-plugin-uglify';
export default {
	input: './js/index.js',
	output: {
		file: './dist/index.bundle.js',
		format: 'iife',
		inlineDynamicImports: true
	},
	plugins: [nodeResolve(), uglify()]
};
