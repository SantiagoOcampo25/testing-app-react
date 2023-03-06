import reactRefresh from '@vitejs/plugin-react-refresh';

export default {
  plugins: [reactRefresh()],
  jsx: {
    factory: 'React.createElement',
    fragment: 'React.Fragment',
    pragma: 'React'
  }
}





