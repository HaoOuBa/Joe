import { nodeResolve } from '@rollup/plugin-node-resolve';
import { uglify } from 'rollup-plugin-uglify';
export default {
	input: './js/joe.write.js',
	output: {
		file: './js/joe.write.chunk.js',
		format: 'iife'
	},
	plugins: [nodeResolve(), uglify()]
};
