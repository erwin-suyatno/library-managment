# Getting Started

## Installation
1. Prerequisites
   - Node.js (v14 or higher)
   - npm or yarn

2. Setup Steps
   ```bash
   # Clone the repository
   git clone <repository-url>
   cd library-management/frontend

   # Install dependencies
   npm install

   # Create .env file
   echo "VITE_API_URL=http://localhost:8000/api" > .env

   # Start development server
   npm run dev
   ```
## Development Environment
1. ***IDE: VS Code recommended***
2. ***Extentions: ***
   - [Tailwind CSS IntelliSense](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss)
   - [Vue 3 Snippets](https://marketplace.visualstudio.com/items?itemName=hkostman.vue-3-snippets)
   - [TypeScript Vue Plugin](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin)

## Project Structure
```bash
├── src
│   ├── components
│   ├── pages
│   ├── services
│   ├── store
│   ├── utils
│   ├── App.vue
│   ├── main.ts
│   ├── shims-vue.d.ts
│   └── vite-env.d.ts
├── tsconfig.app.json
├── tsconfig.node.json
├── tsconfig.json
├── vite.config.ts
└── package.json
```