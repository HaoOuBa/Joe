import { nodeResolve } from '@rollup/plugin-node-resolve';
import { uglify } from 'rollup-plugin-uglify';
export default {
	input: './js/index.js',
	output: {
		dir: './dist',
		format: 'es'
	},
	preserveEntrySignatures: false,
	plugins: [nodeResolve(), uglify()]
};
