import React from 'react'
import PageComponent from '../../components/PageComponent'
import { useStateContext } from '../../contexts/ContextProvider'
import CategoryListItem from '../../components/CategoryListItem';

const Category = () => {
    const { categories } = useStateContext();

    console.log(categories);

    return (
        <>
            <PageComponent title="Categories">
                <div className='grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3'>
                    {categories.map(category => (
                        <CategoryListItem key={category.id} category={category} />
                    ))}
                </div>
            </PageComponent>
        </>
    )
}

export default Category
