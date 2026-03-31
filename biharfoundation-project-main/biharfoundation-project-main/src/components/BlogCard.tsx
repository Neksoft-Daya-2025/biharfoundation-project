import React from 'react';
import { Link } from 'react-router-dom';
import { User, Calendar, ArrowRight } from 'lucide-react';
import { Blog } from '../types';
import { motion } from 'motion/react';

interface BlogCardProps {
  blog: Blog;
}

const BlogCard: React.FC<BlogCardProps> = ({ blog }) => {
  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      className="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 card-hover flex flex-col"
    >
      <div className="relative h-56 overflow-hidden">
        <img 
          src={blog.image} 
          alt={blog.title} 
          className="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
          referrerPolicy="no-referrer"
        />
        <div className="absolute top-4 left-4 bg-saffron text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
          {blog.category}
        </div>
      </div>
      <div className="p-6 flex flex-col flex-grow">
        <div className="flex items-center gap-4 mb-4 text-xs text-slate-400 font-medium">
          <div className="flex items-center gap-1">
            <User size={14} className="text-saffron" />
            <span>{blog.author}</span>
          </div>
          <div className="flex items-center gap-1">
            <Calendar size={14} className="text-saffron" />
            <span>{new Date(blog.date).toLocaleDateString('en-NL', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
          </div>
        </div>
        <h3 className="text-xl font-bold mb-3 text-slate-900 leading-tight group-hover:text-saffron transition-colors">
          {blog.title}
        </h3>
        <p className="text-slate-600 text-sm mb-6 line-clamp-3">
          {blog.excerpt}
        </p>
        <Link to={`/blog/${blog.id}`} className="mt-auto text-saffron font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
          Read More <ArrowRight size={16} />
        </Link>
      </div>
    </motion.div>
  );
};

export default BlogCard;
