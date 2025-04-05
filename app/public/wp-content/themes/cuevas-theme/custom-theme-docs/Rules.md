# Project Rules

## Overview
Project rules are stored in `.cursor/rules/` and customize AI behavior for specific file types or folders. These rules ensure consistency in coding style, architecture, and best practices.

## Key Rules
- **TypeScript Style**: Enforces arrow functions and interfaces in `.ts` files.  
- **Configuration Schema**: Ensures JSON config files follow a standard schema.  
- **Jest Tests**: Promotes best practices for writing unit tests (if applicable).  
- **UI Components**: Maintains consistent structure for React components (if used).  
- **Generated Files**: Adds warnings to auto-generated files to prevent manual edits.  

## How to Use
- Rules are automatically applied based on file paths using glob patterns.  
- Use `@file` to reference additional context (e.g., shared types or schemas).  
- Create new rules via `Cmd + Shift + P` > `New Cursor Rule` in your IDE. 